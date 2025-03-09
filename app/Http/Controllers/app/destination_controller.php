<?php

namespace App\Http\Controllers\app;

use App\Http\Controllers\Controller;
use App\Models\ArrivalPoint;
use App\Models\DeparturePoint;
use App\Models\ShipDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class destination_controller extends Controller
{
    public function index(Request $request)
    {
        $currentDate = Carbon::now('Asia/Dhaka')->toDateString();

        $query = DB::table('ship_details')
            ->join('departure_points', 'ship_details.id', '=', 'departure_points.shipDetails_id')
            ->join('arrival_points', 'departure_points.id', '=', 'arrival_points.departurePoints_id')
            ->join('seat_maps', 'arrival_points.id', '=', 'seat_maps.arrivalPoints_id')
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
            )->where('departure_points.status', '=', 'active');

        // Filter by departure_date or use current date
        if ($request->has('departure_date')) {
            $departureDate = $request->input('departure_date');

            // Check if the requested departure_date is less than the current date
            if (Carbon::parse($departureDate)->lt($currentDate)) {
                // If no departure date is provided, use the current date
                $query->where('departure_points.departure_date', '=', $currentDate);
            } else {
                // Else, use the requested departure date
                $query->where('departure_points.departure_date', '=', $departureDate);
            }
        } else {
            // If no departure date is provided, use the current date
            $query->where('departure_points.departure_date', '=', $currentDate);
        }
        if ($request->has('departure_from')) {
            $query->where('departure_points.departure_point', '=', $request->input('departure_from'));
        }
        // Filter by ship_name if provided
        if ($request->has('ship_name')) {
            $query->where('ship_details.ship_name', 'like', '%' . $request->input('ship_name') . '%');
        }

        // Filter by available_seats if provided
        if ($request->has('available_seats')) {
            $query->where('seat_maps.available_seats', '>=', $request->input('available_seats'));
        }

        // Filter by arrival_to if provided
        if ($request->has('arrival_to')) {
            $query->where('arrival_points.arrival_point', '=', $request->input('arrival_to'));
        }

        // Filter by date range if provided
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('departure_points.departure_date', [$request->input('start_date'), $request->input('end_date')]);
        }

        // Fetch and format results
        $shipDetails = $query->get()
            ->groupBy('ship_name')
            ->map(function ($shipGroup) use ($request) {
                $shipDetails = $shipGroup->first();

                // Determine arrival points and filter seats based on 'arrival_to' if provided
                $arrivalPoints = $shipGroup->groupBy('arrival_point')->map(function ($arrivalGroup, $arrivalPoint) use ($request) {
                    $seats = $arrivalGroup->map(function ($seat) {
                        return [
                            'category' => $seat->category,
                            'seat_price' => $seat->seat_price,
                            'available_seats' => $seat->available_seats,
                        ];
                    })->unique('category')->values()->toArray();

                    return [
                        'arrival_point_id' => $arrivalGroup->first()->arrival_point_id,
                        'arrival_point' => $arrivalPoint,
                        'seats' => $seats,
                    ];
                })->values()->toArray();

                return [
                    'id' => $shipDetails->id,
                    'ship_name' => $shipDetails->ship_name,
                    'couch_no' => $shipDetails->couch_no,
                    'departure_point_id' => $shipDetails->departure_point_id,
                    'departure_point' => $shipDetails->departure_point,
                    'departure_time' => Carbon::parse($shipDetails->departure_time)->format('h:i A'), // Format time with AM/PM
                    'departure_date' => Carbon::parse($shipDetails->departure_date)->format('Y-m-d'), // Format date
                    'arrival_points' => array_values($arrivalPoints), // Reset array keys
                ];
            })
            ->values();


        return response()->json($shipDetails);
    }

    public function suggestShipName(Request $request)
    {
        $query = $request->input('query');
        $ships = ShipDetail::where('ship_name', 'like', '%' . $query . '%')
            ->distinct() // Ensure unique ship names
            ->limit(5)
            ->pluck('ship_name');

        return response()->json($ships);
    }

    // Suggest departure points
    public function suggestDepartureFrom(Request $request)
    {
        $query = $request->input('query');
        $points = DeparturePoint::where('departure_point', 'like', '%' . $query . '%')
            ->distinct() // Ensure unique departure points
            ->limit(5)
            ->pluck('departure_point');

        return response()->json($points);
    }

    // Suggest arrival points
    public function suggestArrivalTo(Request $request)
    {
        $query = $request->input('query');
        $points = ArrivalPoint::where('arrival_point', 'like', '%' . $query . '%')
            ->distinct() // Ensure unique arrival points
            ->limit(5)
            ->pluck('arrival_point');

        return response()->json($points);
    }
}
