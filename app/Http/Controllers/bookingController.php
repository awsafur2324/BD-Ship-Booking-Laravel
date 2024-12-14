<?php

namespace App\Http\Controllers;

use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class bookingController extends Controller
{
    //
    public function shipView($id, $departure_id)
    {
        $ship_id = $id;

        // Fetch data from the database
        $shipDetails = DB::table('ship_details')
            ->join('refund_policies', 'ship_details.id', '=', 'refund_policies.shipDetails_id')
            ->join('departure_points', 'ship_details.id', '=', 'departure_points.shipDetails_id')
            ->join('arrival_points', 'departure_points.id', '=', 'arrival_points.departurePoints_id')
            ->join('seat_maps', 'ship_details.id', '=', 'seat_maps.shipDetails_id')
            ->where([
                ['ship_details.id', '=', $ship_id],
                ['departure_points.id', '=', $departure_id]
            ])
            ->select(
                'ship_details.id',
                'ship_details.ship_name',
                'ship_details.couch_no',
                'ship_details.ship_register_no',
                'refund_policies.refund_category',
                'refund_policies.refund_time',
                'departure_points.departure_point',
                'departure_points.departure_time',
                'departure_points.departure_date',
                'arrival_points.arrival_point',
                'arrival_points.arrival_time',
                'arrival_points.arrival_date',
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
                    'departure_point' => $shipDetails->departure_point,
                    'departure_time' => $shipDetails->departure_time,
                    'departure_date' => $shipDetails->departure_date,
                    'arrival_point' => $shipDetails->arrival_point,
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
                            'category' => $seat->category,
                            'seat_price' => $seat->seat_price,
                        ];
                    })->unique(function ($seat) {
                        return $seat['category'] . '-' . $seat['seat_price'];
                    })->values()
                ];
            })
            ->values();
        if ($shipDetails->isEmpty()) {
            return response()->json(['status' => 'error', 'message' => 'Ship not found']);
        }

        return view('pages.app.booking-page', ['shipDetails' => $shipDetails]);
    }
}
