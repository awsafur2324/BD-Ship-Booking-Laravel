<?php

namespace App\Http\Controllers;

use App\Helper\sslCommerce;
use App\Models\Invoice;
use App\Models\InvoiceSeat;
use App\Models\RefundHistory;
use App\Models\SeatMap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class refundRequest_controller extends Controller
{
    //find all refund request for manager
    function getAllRefundRequest(request $request)
    {

        $user_id = $request->header('id');

        $bookings = DB::table('invoices')
            ->join('ship_details', 'invoices.shipDetails_id', '=', 'ship_details.id')
            ->join('refund_histories', 'invoices.id', '=', 'refund_histories.invoices_id')
            ->join('refund_policies', 'refund_histories.refund_policy_id', '=', 'refund_policies.id')
            ->join('departure_points', 'invoices.departure_id', '=', 'departure_points.id')
            ->leftJoin('invoice_seats', 'invoices.id', '=', 'invoice_seats.invoice_id')
            ->select(
                'invoices.id',
                'ship_details.ship_name',
                'ship_details.couch_no',
                'departure_points.departure_point',
                'departure_points.departure_date',
                'departure_points.departure_time',
                'refund_histories.id as refund_id',
                'refund_histories.reason',
                'refund_histories.Refund_status',
                'refund_histories.Refund_amount',
                'refund_policies.refund_category',
                'invoices.payable as total_price',
                DB::raw("GROUP_CONCAT(invoice_seats.seat_tag) as all_seats")
            )
            ->where('ship_details.user_id', $user_id)
            ->where('refund_histories.Refund_status', 'Pending')
            ->groupBy(
                'invoices.id',
                'invoices.payable',
                'ship_details.ship_name',
                'ship_details.couch_no',
                'departure_points.departure_point',
                'departure_points.departure_date',
                'departure_points.departure_time',
                'refund_histories.id',
                'refund_histories.reason',
                'refund_histories.Refund_status',
                'refund_histories.Refund_amount',
                'refund_policies.refund_category',
                
            )
            ->get()
            ->map(function ($invoice) {
                return [
                    'id' => $invoice->id,
                    'ship_name' => $invoice->ship_name,
                    'couch_no' => $invoice->couch_no,
                    'all_seats' => explode(',', $invoice->all_seats), // Convert seat_tag string to array
                    'place' => $invoice->departure_point,
                    'date' => $invoice->departure_date,
                    'time' => $invoice->departure_time,
                    'total_price' => $invoice->total_price,
                    'refund_id' => $invoice->refund_id,
                    'reason' => $invoice->reason,
                    'refund_category' => $invoice->refund_category,
                    'refund_price' => $invoice->Refund_amount
                ];
            });

        return response()->json($bookings);
    }

    //approve refund request
    public function acceptRefundRequest(Request $request)
    {
        $user_id = $request->header('id');

        if (!$user_id) {
            return response()->json(['success' => false, 'message' => 'User not found']);
        }

        $refund_history_id = $request->input('refund_id');
        $Invoice_id = $request->input('invoice_id');
        $refund_amount = $request->input('refund_amount');
        $refund_reason = $request->input('reason');
        $tran_id = Invoice::where('id', $Invoice_id)->first()->tran_id;

        DB::beginTransaction();

        try {
            $result = sslCommerce::InitiateRefund($tran_id, $refund_amount, $refund_reason);

            // Log the result for debugging purposes
            // Log::info('Refund API Result: ', $result);

            if ($result['success'] == true) {
                // Update invoice status to 'Refund'
                Invoice::where('id', $Invoice_id)->update(['payment_status' => 'Refund']);

                // Update refund history to 'Accepted'
                RefundHistory::where('id', $refund_history_id)->update([
                    'Refund_amount' => $refund_amount,
                    'Refund_status' => 'Accepted'
                ]);

                // Increment available seats in the seat map
                $seatMap_ids = InvoiceSeat::where('invoice_id', $Invoice_id)->pluck('seatMap_id');
                SeatMap::whereIn('id', $seatMap_ids)->increment('available_seats', 1);

                DB::commit();

                return response()->json(['success' => true, 'message' => 'Refund request accepted successfully']);
            } else {
                return response()->json(['success' => false, 'message' => $result['message']]);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            // Log::error('Error processing refund', ['error_message' => $e->getMessage()]);

            return response()->json(['success' => false, 'message' => 'Error processing refund', 'error' => $e->getMessage()]);
        }
    }

    //view user refund status
    function viewUserRefundRequests(Request $request)
    {
        $user_id = $request->header('id');
        $refundsData = DB::table('invoices')
        ->join('ship_details', 'invoices.shipDetails_id', '=', 'ship_details.id')
        ->join('refund_histories', 'invoices.id', '=', 'refund_histories.invoices_id')
        ->join('refund_policies', 'refund_histories.refund_policy_id', '=', 'refund_policies.id')
        ->join('departure_points', 'invoices.departure_id', '=', 'departure_points.id')
        ->leftJoin('invoice_seats', 'invoices.id', '=', 'invoice_seats.invoice_id')
        ->select(
            'invoices.id',
            'ship_details.ship_name',
            'ship_details.couch_no',
            'departure_points.departure_point',
            'departure_points.departure_date',
            'departure_points.departure_time',
            'refund_histories.id as refund_id',
            'refund_histories.reason',
            'refund_histories.Refund_status',
            'refund_policies.refund_category',
            'invoices.payable as total_price',
            DB::raw("GROUP_CONCAT(invoice_seats.seat_tag) as all_seats")
        )
        ->where('refund_histories.user_id', $user_id)
        ->groupBy(
            'invoices.id',
            'invoices.payable',
            'ship_details.ship_name',
            'ship_details.couch_no',
            'departure_points.departure_point',
            'departure_points.departure_date',
            'departure_points.departure_time',
            'refund_histories.id',
            'refund_histories.reason',
            'refund_histories.Refund_status',
            'refund_policies.refund_category'
        )
        ->get()
        ->map(function ($invoice) {
            if ($invoice->refund_category == 'Half') {
                $refund_price = $invoice->total_price / 2;
            } else {
                $refund_price = $invoice->total_price;
            }
            return [
                'id' => $invoice->id,
                'ship_name' => $invoice->ship_name,
                'couch_no' => $invoice->couch_no,
                'all_seats' => explode(',', $invoice->all_seats), // Convert seat_tag string to array
                'place' => $invoice->departure_point,
                'date' => $invoice->departure_date,
                'time' => $invoice->departure_time,
                'total_price' => $invoice->total_price,
                'refund_id' => $invoice->refund_id,
                'reason' => $invoice->reason,
                'refund_category' => $invoice->refund_category,
                'refund_status' => $invoice->Refund_status,
                'refund_price' => $refund_price
            ];
        });

        return response()->json($refundsData);
    }

    function viewManagerRefundRequests (Request $request){
        $user_id = $request->header('id');
        $refundsData = DB::table('invoices')
        ->join('ship_details', 'invoices.shipDetails_id', '=', 'ship_details.id')
        ->join('refund_histories', 'invoices.id', '=', 'refund_histories.invoices_id')
        ->join('refund_policies', 'refund_histories.refund_policy_id', '=', 'refund_policies.id')
        ->join('departure_points', 'invoices.departure_id', '=', 'departure_points.id')
        ->leftJoin('invoice_seats', 'invoices.id', '=', 'invoice_seats.invoice_id')
        ->select(
            'invoices.id',
            'ship_details.ship_name',
            'ship_details.couch_no',
            'departure_points.departure_point',
            'departure_points.departure_date',
            'departure_points.departure_time',
            'refund_histories.id as refund_id',
            'refund_histories.reason',
            'refund_histories.Refund_status',
            'refund_policies.refund_category',
            'invoices.payable as total_price',
            DB::raw("GROUP_CONCAT(invoice_seats.seat_tag) as all_seats")
        )
        ->where('ship_details.user_id', $user_id)
        ->where('refund_histories.Refund_status', 'Accepted')
        ->groupBy(
            'invoices.id',
            'invoices.payable',
            'ship_details.ship_name',
            'ship_details.couch_no',
            'departure_points.departure_point',
            'departure_points.departure_date',
            'departure_points.departure_time',
            'refund_histories.id',
            'refund_histories.reason',
            'refund_histories.Refund_status',
            'refund_policies.refund_category'
        )
        ->get()
        ->map(function ($invoice) {
            if ($invoice->refund_category == 'Half') {
                $refund_price = $invoice->total_price / 2;
            } else {
                $refund_price = $invoice->total_price;
            }
            return [
                'id' => $invoice->id,
                'ship_name' => $invoice->ship_name,
                'couch_no' => $invoice->couch_no,
                'all_seats' => explode(',', $invoice->all_seats), // Convert seat_tag string to array
                'place' => $invoice->departure_point,
                'date' => $invoice->departure_date,
                'time' => $invoice->departure_time,
                'total_price' => $invoice->total_price,
                'refund_id' => $invoice->refund_id,
                'reason' => $invoice->reason,
                'refund_category' => $invoice->refund_category,
                'refund_status' => $invoice->Refund_status,
                'refund_price' => $refund_price
            ];
        });

        return response()->json($refundsData);
    }
}
