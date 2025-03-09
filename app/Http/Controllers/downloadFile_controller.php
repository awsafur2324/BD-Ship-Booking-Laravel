<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class downloadFile_controller extends Controller
{
    //
    public function downloadTicket($id)
    {
        // Fetch booking details along with the related user data
        $booking = DB::table('invoices')
            ->join('ship_details', 'invoices.shipDetails_id', '=', 'ship_details.id')
            ->join('departure_points', 'invoices.departure_id', '=', 'departure_points.id')
            ->join('arrival_points', 'departure_points.id', '=', 'arrival_points.departurePoints_id')
            ->join('users', 'invoices.user_id', '=', 'users.id') // Join with the users table
            ->where('invoices.id', $id)
            ->select(
                'ship_details.ship_name',
                'ship_details.couch_no',
                'departure_points.departure_point',
                'departure_points.departure_date',
                'departure_points.departure_time',
                'arrival_points.arrival_point',
                'invoices.payable',
                'users.name as user_name', // Get user's name
                'users.phone as user_phone' // Get user's phone number
            )
            ->first();


        // Format the date and time
        $formattedDate = Carbon::parse($booking->departure_date)->format('d-m-Y');
        $formattedTime = Carbon::parse($booking->departure_time)->format('h:i A');

        // Fetch seat details using a raw query
        $seats = DB::table('invoice_seats')
            ->where('invoice_seats.invoice_id', $id)
            ->pluck('seat_tag')
            ->toArray();

        // Prepare data for the PDF
        $data = [
            'ship_name' => $booking->ship_name,
            'couch_no' => $booking->couch_no,
            'seats' => implode(', ', $seats),
            'departure_point' => $booking->departure_point,
            'arrival_point' => $booking->arrival_point,
            'date' => $formattedDate,
            'time' => $formattedTime,
            'user_name' => $booking->user_name,
            'user_phone' => $booking->user_phone,
            'total_price' => $booking->payable,
        ];

        // Generate the PDF
        $pdf = Pdf::loadView('pdf.ticket', $data);

        // Return the PDF as a download
        return $pdf->download('ticket.pdf');
    }

    function exportSalesReport(Request $request)
    {
        // Fetch earnings data
        $earnings = Invoice::selectRaw('departure_points.departure_date as date, SUM(invoices.payable) as total')
            ->join('departure_points', 'invoices.departure_id', '=', 'departure_points.id')
            ->where('invoices.payment_status', 'Success')
            ->groupBy('departure_points.departure_date')
            ->orderBy('departure_points.departure_date')
            ->get();

        // Format the CSV content
        $csvData = "Date, TotalEarnings (BDT)\n";
        foreach ($earnings as $earning) {
            $formattedDate = Carbon::parse($earning->date)->format('d-m-Y');
            $csvData .= "{$formattedDate},{$earning->total}\n";
        }

        // Set the filename
        $fileName = 'sales_report_' . now()->format('Y_m_d_H_i_s') . '.csv';

        // Return CSV as a response
        return Response::make($csvData, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$fileName}",
        ]);
    }

    function exportBookingHistory(Request $request)
    {   // Raw query to fetch booking history data, grouping seat tags by invoice_id
        $bookings = DB::table('invoices')
            ->join('ship_details', 'invoices.shipDetails_id', '=', 'ship_details.id')
            ->join('departure_points', 'invoices.departure_id', '=', 'departure_points.id')
            ->join('users as customers', 'invoices.user_id', '=', 'customers.id')
            ->leftJoin('invoice_seats', 'invoices.id', '=', 'invoice_seats.invoice_id')
            ->select(
                'ship_details.ship_name',
                'ship_details.couch_no',
                'ship_details.ship_manager_name',
                'ship_details.ship_manager_number',
                'customers.name as customer_name',
                'customers.phone as customer_phone',
                'departure_points.departure_date',
                DB::raw('GROUP_CONCAT(invoice_seats.seat_tag SEPARATOR ", ") as seat_tags'),
                'invoices.tran_id',
                'invoices.payable'
            )
            ->where('invoices.payment_status', 'Success')
            ->groupBy(
                'invoices.id',
                'invoices.tran_id',
                'invoices.payable',
                'ship_details.id',
                'ship_details.ship_name',
                'ship_details.couch_no',
                'ship_details.ship_manager_name',
                'ship_details.ship_manager_number',
                'customers.id',
                'customers.name',
                'customers.phone',
                'departure_points.id',
                'departure_points.departure_date'
            )
            ->get();

        // Prepare the CSV header
        $csvData = "Ship Name,Couch No,Manager Name,Manager Number,Customer Name ,Customer Phone,Date,Seats,Transaction ID,Payable\n";

        // Loop through bookings and format data
        foreach ($bookings as $booking) {
            $shipName = $booking->ship_name ?? 'N/A';
            $couchNo = $booking->couch_no ?? 'N/A';
            $managerName = $booking->ship_manager_name ?? 'N/A';
            $managerNumber = $booking->ship_manager_number ?? 'N/A';
            $customerName = $booking->customer_name ?? 'N/A';
            $customerPhone = $booking->customer_phone ?? 'N/A';
            $date = $booking->departure_date ?? 'N/A';
            $formattedDate = $date !== 'N/A' ? \Carbon\Carbon::parse($date)->format('d-m-Y') : 'N/A';
            $seats = $booking->seat_tags ?? 'N/A';  // Concatenated seat tags
            $tranId = $booking->tran_id ?? 'N/A';
            $payable = $booking->payable ?? 0;

            // Add data to CSV string
            $csvData .= "\"{$shipName}\",\"{$couchNo}\",\"{$managerName}\",\"{$managerNumber}\",\"{$customerName}\",\"{$customerPhone}\",\"{$formattedDate}\",\"{$seats}\",\"{$tranId}\",\"{$payable}\"\n";
        }

        // Set the filename
        $fileName = 'booking_history_' . now()->format('Y_m_d_H_i_s') . '.csv';

        // Return CSV as a response
        return Response::make($csvData, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$fileName}",
        ]);
    }

    function exportRefundHistory(Request $request)
    {
        // Raw query to fetch refund history data

        $refunds = DB::table('refund_histories')
            ->join('ship_details', 'refund_histories.shipDetails_id', '=', 'ship_details.id')
            ->join('departure_points', 'refund_histories.departure_id', '=', 'departure_points.id')
            ->join('users as customers', 'refund_histories.user_id', '=', 'customers.id')
            ->join('refund_policies', 'refund_histories.refund_policy_id', '=', 'refund_policies.id')
            ->leftJoin('invoice_seats', 'refund_histories.invoices_id', '=', 'invoice_seats.invoice_id')
            ->select(
                'refund_histories.id', // Include primary key of refund_histories
                'ship_details.id as ship_detail_id', // Primary key of ship_details
                'ship_details.ship_name',
                'ship_details.couch_no',
                'ship_details.ship_manager_name',
                'ship_details.ship_manager_number',
                'customers.id as customer_id', // Primary key of customers
                'customers.name as customer_name',
                'customers.phone as customer_phone',
                'departure_points.id as departure_point_id', // Primary key of departure_points
                'departure_points.departure_date',
                'refund_policies.id as refund_policy_id', // Primary key of refund_policies
                'refund_policies.refund_category',
                'refund_histories.reason',
                'refund_histories.Refund_amount',
                DB::raw('GROUP_CONCAT(invoice_seats.seat_tag SEPARATOR ", ") as seat_tags')
            )
            ->where('refund_histories.Refund_status', 'Accepted')
            ->groupBy(
                'refund_histories.id',                 // Include all refund_histories columns
                'ship_details.id',                    // Include all ship_details columns
                'ship_details.ship_name',
                'ship_details.couch_no',
                'ship_details.ship_manager_name',
                'ship_details.ship_manager_number',
                'customers.id',                       // Include all customer columns
                'customers.name',
                'customers.phone',
                'departure_points.id',                // Include all departure_points columns
                'departure_points.departure_date',
                'refund_policies.id',                 // Include all refund_policies columns
                'refund_policies.refund_category',
                'refund_histories.reason',
                'refund_histories.Refund_amount'
            )
            ->get();

        // Prepare the CSV header
        $csvData = "Ship Name,Couch No,Manager Name,Manager Number,Customer Name,Customer Phone,Date,Seats,Reason,Refund Category,Refund Amount\n";

        // Loop through refunds and format data
        foreach ($refunds as $refund) {
            $shipName = $refund->ship_name ?? 'N/A';
            $couchNo = $refund->couch_no ?? 'N/A';
            $managerName = $refund->ship_manager_name ?? 'N/A';
            $managerNumber = $refund->ship_manager_number ?? 'N/A';
            $customerName = $refund->customer_name ?? 'N/A';
            $customerPhone = $refund->customer_phone ?? 'N/A';
            $date = $refund->departure_date ?? 'N/A';
            $formattedDate = $date !== 'N/A' ? \Carbon\Carbon::parse($date)->format('d-m-Y') : 'N/A';
            $seats = $refund->seat_tags ?? 'N/A';  // Concatenated seat tags
            $reason = $refund->reason ?? 'N/A';
            $refundCategory = $refund->refund_category ?? 'N/A';
            $refundAmount = $refund->Refund_amount ?? 0;

            // Add data to CSV string
            $csvData .= "\"{$shipName}\",\"{$couchNo}\",\"{$managerName}\",\"{$managerNumber}\",\"{$customerName}\",\"{$customerPhone}\",\"{$formattedDate}\",\"{$seats}\",\"{$reason}\",\"{$refundCategory}\",\"{$refundAmount}\"\n";
        }

        // Set the filename
        $fileName = 'refund_history_' . now()->format('Y_m_d_H_i_s') . '.csv';

        // Return CSV as a response
        return Response::make($csvData, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$fileName}",
        ]);
    }

    function exportManagerBookingHistory(Request $request)
    {
        $user_id = $request->header('id');
        $bookings = DB::table('invoices')
            ->join('ship_details', 'invoices.shipDetails_id', '=', 'ship_details.id')
            ->join('departure_points', 'invoices.departure_id', '=', 'departure_points.id')
            ->join('users as customers', 'invoices.user_id', '=', 'customers.id')
            ->leftJoin('invoice_seats', 'invoices.id', '=', 'invoice_seats.invoice_id')
            ->select(
                'ship_details.ship_name',
                'ship_details.couch_no',
                'ship_details.ship_manager_name',
                'ship_details.ship_manager_number',
                'customers.name as customer_name',
                'customers.phone as customer_phone',
                'departure_points.departure_date',
                DB::raw('GROUP_CONCAT(invoice_seats.seat_tag SEPARATOR ", ") as seat_tags'),
                'invoices.tran_id',
                'invoices.payable'
            )
            ->where('invoices.payment_status', 'Success')
            ->where('ship_details.user_id', $user_id)
            ->groupBy(
                'invoices.id',
                'invoices.tran_id',
                'invoices.payable',
                'ship_details.id',
                'ship_details.ship_name',
                'ship_details.couch_no',
                'ship_details.ship_manager_name',
                'ship_details.ship_manager_number',
                'customers.id',
                'customers.name',
                'customers.phone',
                'departure_points.id',
                'departure_points.departure_date'
            )
            ->get();

        // Prepare the CSV header
        $csvData = "Ship Name,Couch No,Manager Name,Manager Number,Customer Name ,Customer Phone,Date,Seats,Transaction ID,Payable\n";

        // Loop through bookings and format data
        foreach ($bookings as $booking) {
            $shipName = $booking->ship_name ?? 'N/A';
            $couchNo = $booking->couch_no ?? 'N/A';
            $managerName = $booking->ship_manager_name ?? 'N/A';
            $managerNumber = $booking->ship_manager_number ?? 'N/A';
            $customerName = $booking->customer_name ?? 'N/A';
            $customerPhone = $booking->customer_phone ?? 'N/A';
            $date = $booking->departure_date ?? 'N/A';
            $formattedDate = $date !== 'N/A' ? \Carbon\Carbon::parse($date)->format('d-m-Y') : 'N/A';
            $seats = $booking->seat_tags ?? 'N/A';  // Concatenated seat tags
            $tranId = $booking->tran_id ?? 'N/A';
            $payable = $booking->payable ?? 0;

            // Add data to CSV string
            $csvData .= "\"{$shipName}\",\"{$couchNo}\",\"{$managerName}\",\"{$managerNumber}\",\"{$customerName}\",\"{$customerPhone}\",\"{$formattedDate}\",\"{$seats}\",\"{$tranId}\",\"{$payable}\"\n";
        }

        // Set the filename
        $fileName = 'booking_history_' . now()->format('Y_m_d_H_i_s') . '.csv';

        // Return CSV as a response
        return Response::make($csvData, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$fileName}",
        ]);
    }

    function exportManagerSalesHistory(Request $request)
    {
        $user_id = $request->header('id');
        // Fetch earnings data
        $earnings = Invoice::selectRaw('departure_points.departure_date as date, SUM(invoices.payable) as total')
            ->join('departure_points', 'invoices.departure_id', '=', 'departure_points.id')
            ->join('ship_details', 'invoices.shipDetails_id', '=', 'ship_details.id')
            ->where('invoices.payment_status', 'Success')
            ->where('ship_details.user_id', $user_id)
            ->groupBy('departure_points.departure_date')
            ->orderBy('departure_points.departure_date')
            ->get();

        // Format the CSV content
        $csvData = "Date, TotalEarnings (BDT)\n";
        foreach ($earnings as $earning) {
            $formattedDate = Carbon::parse($earning->date)->format('d-m-Y');
            $csvData .= "{$formattedDate},{$earning->total}\n";
        }

        // Set the filename
        $fileName = 'sales_report_' . now()->format('Y_m_d_H_i_s') . '.csv';

        // Return CSV as a response
        return Response::make($csvData, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$fileName}",
        ]);
    }

    function exportManagerRefundHistory(Request $request){
        $user_id = $request->header('id');
         // Raw query to fetch refund history data

         $refunds = DB::table('refund_histories')
         ->join('ship_details', 'refund_histories.shipDetails_id', '=', 'ship_details.id')
         ->join('invoices', 'ship_details.id', '=', 'invoices.shipDetails_id')
         ->join('departure_points', 'refund_histories.departure_id', '=', 'departure_points.id')
         ->join('users as customers', 'refund_histories.user_id', '=', 'customers.id')
         ->join('refund_policies', 'refund_histories.refund_policy_id', '=', 'refund_policies.id')
         ->leftJoin('invoice_seats', 'refund_histories.invoices_id', '=', 'invoice_seats.invoice_id')
         ->select(
             'refund_histories.id', // Include primary key of refund_histories
             'ship_details.id as ship_detail_id', // Primary key of ship_details
             'ship_details.ship_name',
             'ship_details.couch_no',
             'ship_details.ship_manager_name',
             'ship_details.ship_manager_number',
             'customers.id as customer_id', // Primary key of customers
             'customers.name as customer_name',
             'customers.phone as customer_phone',
             'departure_points.id as departure_point_id', // Primary key of departure_points
             'departure_points.departure_date',
             'refund_policies.id as refund_policy_id', // Primary key of refund_policies
             'refund_policies.refund_category',
             'refund_histories.reason',
             'refund_histories.Refund_amount',
             DB::raw('GROUP_CONCAT(invoice_seats.seat_tag SEPARATOR ", ") as seat_tags')
         )
         ->where('refund_histories.Refund_status', 'Accepted')
         ->where('ship_details.user_id', $user_id)
         ->groupBy(
             'refund_histories.id',                 // Include all refund_histories columns
             'ship_details.id',                    // Include all ship_details columns
             'ship_details.ship_name',
             'ship_details.couch_no',
             'ship_details.ship_manager_name',
             'ship_details.ship_manager_number',
             'customers.id',                       // Include all customer columns
             'customers.name',
             'customers.phone',
             'departure_points.id',                // Include all departure_points columns
             'departure_points.departure_date',
             'refund_policies.id',                 // Include all refund_policies columns
             'refund_policies.refund_category',
             'refund_histories.reason',
             'refund_histories.Refund_amount'
         )
         ->get();

     // Prepare the CSV header
     $csvData = "Ship Name,Couch No,Manager Name,Manager Number,Customer Name,Customer Phone,Date,Seats,Reason,Refund Category,Refund Amount\n";

     // Loop through refunds and format data
     foreach ($refunds as $refund) {
         $shipName = $refund->ship_name ?? 'N/A';
         $couchNo = $refund->couch_no ?? 'N/A';
         $managerName = $refund->ship_manager_name ?? 'N/A';
         $managerNumber = $refund->ship_manager_number ?? 'N/A';
         $customerName = $refund->customer_name ?? 'N/A';
         $customerPhone = $refund->customer_phone ?? 'N/A';
         $date = $refund->departure_date ?? 'N/A';
         $formattedDate = $date !== 'N/A' ? \Carbon\Carbon::parse($date)->format('d-m-Y') : 'N/A';
         $seats = $refund->seat_tags ?? 'N/A';  // Concatenated seat tags
         $reason = $refund->reason ?? 'N/A';
         $refundCategory = $refund->refund_category ?? 'N/A';
         $refundAmount = $refund->Refund_amount ?? 0;

         // Add data to CSV string
         $csvData .= "\"{$shipName}\",\"{$couchNo}\",\"{$managerName}\",\"{$managerNumber}\",\"{$customerName}\",\"{$customerPhone}\",\"{$formattedDate}\",\"{$seats}\",\"{$reason}\",\"{$refundCategory}\",\"{$refundAmount}\"\n";
     }

     // Set the filename
     $fileName = 'refund_history_' . now()->format('Y_m_d_H_i_s') . '.csv';

     // Return CSV as a response
     return Response::make($csvData, 200, [
         'Content-Type' => 'text/csv',
         'Content-Disposition' => "attachment; filename={$fileName}",
     ]);
    }
}
