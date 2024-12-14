<?php

namespace App\Http\Controllers\app;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class miniShipSearch_Controller extends Controller
{
    public function miniShipSearch(Request $request)
    {
        // Fetch and join all necessary data
        $shipDetails = DB::table('ship_details')
            ->join('departure_points', 'ship_details.id', '=', 'departure_points.shipDetails_id')
            ->join('arrival_points', 'departure_points.id', '=', 'arrival_points.departurePoints_id')
            ->join('seat_maps', 'ship_details.id', '=', 'seat_maps.shipDetails_id')
            ->where([
                ['departure_points.departure_point', '=', $request->input('departure')],
                ['departure_points.departure_date', '=', $request->input('date')],
                ['arrival_points.arrival_point', '=', $request->input('arrival')],
            ])
            ->select(
                'ship_details.id',
                'ship_details.ship_name',
                'ship_details.couch_no',
                'departure_points.id as departure_point_id',
                'departure_points.departure_point',
                'departure_points.departure_time',
                'departure_points.departure_date',
                'arrival_points.arrival_point',
                'seat_maps.category',
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
                    'departure_point_id' => $shipDetails->departure_point_id,
                    'departure_point' => $shipDetails->departure_point,
                    'departure_time' => $shipDetails->departure_time,
                    'departure_date' => $shipDetails->departure_date,
                    'arrival_point' => $shipDetails->arrival_point,
                    // Collect seats into a nested array
                    'seats' => $shipGroup->map(function ($seat) {
                        return [
                            'category' => $seat->category,
                            'seat_price' => $seat->seat_price,
                        ];
                    })->values()
                ];
            })
            ->values();

        return response()->json($shipDetails);
    }
}
