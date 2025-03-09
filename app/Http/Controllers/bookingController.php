<?php

namespace App\Http\Controllers;

use App\Models\AddDiscount;
use App\Models\User;
use App\Models\Booking;
use App\Models\Invoice;
use App\Models\InvoiceSeat;
use App\Models\RefundHistory;
use Carbon\Carbon;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class bookingController extends Controller
{
    //
    public function shipView($id, $departure_id, $arrival_id)
    {
        $user_id = request()->header('id');
        $user = User::where('id', $user_id)->first();
        $ship_id = $id;
        //------ Get ship details by id and departure_id -----//
        // Fetch data from the database
        $shipDetails = DB::table('ship_details')
            ->join('refund_policies', 'ship_details.id', '=', 'refund_policies.shipDetails_id')
            ->join('departure_points', 'ship_details.id', '=', 'departure_points.shipDetails_id')
            ->join('arrival_points', 'departure_points.id', '=', 'arrival_points.departurePoints_id')
            ->join('seat_maps', 'arrival_points.id', '=', 'seat_maps.arrivalPoints_id')
            ->where([
                ['ship_details.id', '=', $ship_id],
                ['departure_points.id', '=', $departure_id],
                ['arrival_points.id', '=', $arrival_id],
            ])
            ->select(
                'ship_details.id',
                'ship_details.ship_name',
                'ship_details.couch_no',
                'ship_details.ship_register_no',
                'refund_policies.refund_category',
                'refund_policies.refund_time',
                'departure_points.id as departure_id',
                'departure_points.departure_point',
                'departure_points.departure_time',
                'departure_points.departure_date',
                'arrival_points.arrival_point',
                'arrival_points.arrival_time',
                'arrival_points.arrival_date',
                'seat_maps.id as seat_map_id',
                'seat_maps.category',
                'seat_maps.seat_in_rows',
                'seat_maps.seat_in_columns',
                'seat_maps.seat_tag',
                'seat_maps.seat_price'
            )
            ->get()
            ->groupBy('ship_name') // Group by ship name to handle nested data
            ->map(function ($shipGroup) {
                // Extract common details
                $shipDetails = $shipGroup->first();
                return [
                    'id' => $shipDetails->id,
                    'ship_name' => $shipDetails->ship_name,
                    'couch_no' => $shipDetails->couch_no,
                    'ship_register_no' => $shipDetails->ship_register_no,
                    'departure_id' => $shipDetails->departure_id,
                    'departure_point' => $shipDetails->departure_point,
                    'departure_time' => $shipDetails->departure_time,
                    'departure_date' => $shipDetails->departure_date,
                    // Collect unique arrival_points
                    'arrival_points' => $shipGroup->map(function ($arrivalPoint) {
                        return [
                            'arrival_point' => $arrivalPoint->arrival_point,
                            'arrival_time' => $arrivalPoint->arrival_time,
                            'arrival_date' => $arrivalPoint->arrival_date,
                        ];
                    })->unique('arrival_point')->values(),
                    // Collect unique refund policies
                    'refund_policies' => $shipGroup->map(function ($refundPolicy) {
                        return [
                            'refund_category' => $refundPolicy->refund_category,
                            'refund_time' => $refundPolicy->refund_time,
                        ];
                    })->unique(function ($policy) {
                        return $policy['refund_category'] . '-' . $policy['refund_time'];
                    })->values(),
                    // Collect unique seats
                    'seats' => $shipGroup->map(function ($seat) {
                        return [
                            'seatMap_id' => $seat->seat_map_id,
                            'category' => $seat->category,
                            'seat_price' => $seat->seat_price,
                            'seat_in_rows' => $seat->seat_in_rows,
                            'seat_in_columns' => $seat->seat_in_columns,
                            'seat_tag' => $seat->seat_tag,
                        ];
                    })->unique(function ($seat) {
                        return $seat['category'] . '-' . $seat['seat_price'];
                    })->values()
                ];
            })
            ->values();

        //All discount offers
        $discountOffers = AddDiscount::where('discount_status', 'active')->get();

        //------booking Seat
        // Fetch booked seats for the ship
        $bookedSeats = InvoiceSeat::whereIn('invoice_id', function ($query) use ($ship_id, $departure_id) {
            $query->select('id')
                ->from('invoices')
                ->where('shipDetails_id', $ship_id)
                ->where('departure_id', $departure_id) // Add condition for departure_id
                ->where('payment_status', 'Success'); // Filter for successful payments only
        })->pluck('seat_tag')->toArray();


        if ($shipDetails->isEmpty()) {
            return response()->json(['status' => 'error', 'message' => 'Ship not found']);
        }
        // return $bookedSeats;
        return view('pages.app.booking-page', [
            'shipDetails' => $shipDetails,
            'user' => $user,
            'discountOffers' => $discountOffers,
            'bookedSeats' => $bookedSeats,
        ]);
    }

    function my_bookings(Request $request)
    {
        $user_id = $request->header('id');

        $bookings = DB::table('invoices')
            ->join('ship_details', 'invoices.shipDetails_id', '=', 'ship_details.id')
            ->join('departure_points', 'invoices.departure_id', '=', 'departure_points.id')
            ->leftJoin('invoice_seats', 'invoices.id', '=', 'invoice_seats.invoice_id')
            ->select(
                'invoices.id as invoice_id',
                'ship_details.ship_name',
                'ship_details.couch_no',
                'departure_points.departure_point',
                'departure_points.departure_date',
                'departure_points.departure_time',
                'invoices.payable as total_price',
                DB::raw("GROUP_CONCAT(invoice_seats.seat_tag) as all_seats")
            )
            ->where('invoices.user_id', $user_id)
            ->where('invoices.payment_status', 'Success')
            ->groupBy(
                'invoices.id',
                'ship_details.ship_name',
                'ship_details.couch_no',
                'departure_points.departure_point',
                'departure_points.departure_date',
                'departure_points.departure_time',
                'invoices.payable'
            )
            ->get()
            ->map(function ($invoice) {
                $status = now('Asia/Dhaka')->lt($invoice->departure_date) ? 'Upcoming' : 'Departed';
                return [
                    'id' => $invoice->invoice_id,
                    'ship_name' => $invoice->ship_name,
                    'couch_no' => $invoice->couch_no,
                    'all_seats' => explode(',', $invoice->all_seats), // Convert seat_tag string to array
                    'place' => $invoice->departure_point,
                    'date' => $invoice->departure_date,
                    'time' => $invoice->departure_time,
                    'status' => $status,
                    'total_price' => $invoice->total_price,
                    'can_refund' => $status === 'Upcoming', // Assuming only upcoming bookings can be refunded
                ];
            });

        return response()->json($bookings);
    }

    //check refund status
    function checkRefundStatus($invoiceID)
    {
        $user_id = request()->header('id');
        $current_date = Carbon::now('Asia/Dhaka'); // Ensure correct timezone

        // Fetch refund policies and invoice details
        $refunds = DB::table('invoices')
            ->join('ship_details', 'invoices.shipDetails_id', '=', 'ship_details.id')
            ->join('refund_policies', 'ship_details.id', '=', 'refund_policies.shipDetails_id')
            ->join('departure_points', 'invoices.departure_id', '=', 'departure_points.id')
            ->where('invoices.id', $invoiceID)
            ->select(
                'invoices.id as invoice_id',
                'refund_policies.id as refund_id',
                'refund_policies.refund_category',
                'refund_policies.refund_time', // Refund time in days
                'departure_points.departure_date as departure_date'
            )
            ->get();

        if ($refunds->isEmpty()) {
            return response()->json(['message' => 'Refund policy or invoice not found'], 404);
        }

        // Parse departure date to a Carbon instance
        $departure_date = Carbon::parse($refunds->first()->departure_date, 'Asia/Dhaka');

        // Calculate the difference in days
        $days_difference = $current_date->diffInDays($departure_date, false); // Negative if past

        // Initialize refund status
        $refund_status = 'No';
        $refund_id = null;
        // Determine refund status based on policies
        foreach ($refunds as $refund) {
            if ($days_difference >= $refund->refund_time && $days_difference > 0) {
                // Apply the highest-priority refund category
                if ($refund->refund_category === 'Full') {
                    $refund_id = $refund->refund_id;
                    $refund_status = 'Full';
                    break; // Stop checking as "Full" is the highest priority
                } elseif ($refund->refund_category === 'Half') {
                    $refund_id = $refund->refund_id;
                    $refund_status = 'Half';
                }
            }
        }

        // Return the response as JSON
        return response()->json([
            'refund_id' => $refund_id,
            'refund_status' => $refund_status,
        ]);
    }

    //refund request
    function insertRefundRequest(Request $request)
    {
        try {
            $user_id = $request->header('id');
            $invoice_id = $request->input('invoice_id');
            $reason = $request->input('reason');
            $refundID = $request->input('refundID');
            $departure_id = Invoice::where('id', $invoice_id)->first()->departure_id;
            $shipDetails_id = Invoice::where('id', $invoice_id)->first()->shipDetails_id;

            //check if this refund is already in the database or not
            $findRefund = RefundHistory::where('invoices_id', $invoice_id)->count();
            if ($findRefund > 0) {
                return response()->json(['status' => false, 'massage' => 'You already claim this refund']);
            }

            $refund_policy = DB::table('refund_policies')
                ->where('id', $refundID)
                ->first();
            $payable = Invoice::where('id', $invoice_id)->first()->payable;
            $refund_amount = 0;
            if ($refund_policy->refund_category == 'Full') {
                $refund_amount = $payable;
            } elseif ($refund_policy->refund_category == 'Half') {
                $refund_amount = $payable / 2;
            }

            RefundHistory::create([
                'reason' => $reason,
                'Refund_amount' => $refund_amount,
                'Refund_status' => 'Pending',
                'invoices_id' => $invoice_id,
                'shipDetails_id' => $shipDetails_id,
                'departure_id' => $departure_id,
                'user_id' => $user_id,
                'refund_policy_id' => $refundID,
            ]);
            return response()->json(['status' => true, 'massage' => 'Successfully claim refund. wait for approve.']);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'massage' => 'Error to claim refund !']);
        }
    }
}
