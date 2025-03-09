<?php

namespace App\Http\Controllers\app;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class miniShipSearch_Controller extends Controller
{
    public function miniShipSearch(Request $request)
    {
        $departure = $request->input('departure'); // Replace with dynamic value
        $arrival = $request->input('arrival'); // Replace with dynamic value
        $date = $request->input('date'); // Replace with dynamic value
        $available_seats = $request->input('guest_no'); // Replace with dynamic value
        // Fetch and join all necessary data
        $shipDetails = DB::table('ship_details')
            ->join('departure_points', 'ship_details.id', '=', 'departure_points.shipDetails_id')
            ->join('arrival_points', 'departure_points.id', '=', 'arrival_points.departurePoints_id')
            ->join('seat_maps', 'arrival_points.id', '=', 'seat_maps.arrivalPoints_id')
            ->where([
                ['departure_points.departure_point', '=', $departure],
                ['departure_points.departure_date', '=', $date],
                ['departure_points.status', '=', 'active'],
                ['arrival_points.arrival_point', '=', $arrival],
                ['seat_maps.available_seats', '>=', $available_seats],
            ])
            ->select(
                'ship_details.id',
                'ship_details.ship_name',
                'ship_details.couch_no',
                'departure_points.id as departure_point_id',
                'departure_points.departure_point',
                'departure_points.departure_time',
                'departure_points.departure_date',
                'arrival_points.id as arrival_point_id',
                'arrival_points.arrival_point',
                'seat_maps.category',
                'seat_maps.seat_price',
                'seat_maps.available_seats'
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
                    'arrival_point_id' => $shipDetails->arrival_point_id,
                    // Collect seats into a nested array
                    'seats' => $shipGroup->map(function ($seat) {
                        return [
                            'category' => $seat->category,
                            'seat_price' => $seat->seat_price,
                            'available_seats' => $seat->available_seats,
                        ];
                    })->values()->unique('category')->toArray(),
                ];
            })
            ->values();

        return response()->json($shipDetails);
    }
}
