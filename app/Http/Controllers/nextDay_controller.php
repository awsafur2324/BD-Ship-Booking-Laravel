<?php

namespace App\Http\Controllers;

use App\Models\ArrivalPoint;
use App\Models\DeparturePoint;
use App\Models\SeatMap;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class nextDay_controller extends Controller
{
    //
    function viewNextDay($ship_id)
    {
        $suggestion = DB::table('departure_points')
            ->join('ship_details', 'departure_points.shipDetails_id', '=', 'ship_details.id')
            ->join('arrival_points', 'departure_points.id', '=', 'arrival_points.departurePoints_id')
            ->join('seat_maps', 'arrival_points.id', '=', 'seat_maps.arrivalPoints_id')
            ->where('ship_details.id', $ship_id)
            ->select(
                'arrival_points.arrival_point',
                'departure_points.departure_point',
                'departure_points.departure_date',
                'seat_maps.category',
                'seat_maps.seat_tag',
            )
            ->distinct()
            ->get();

        $place_suggestion = $suggestion->flatMap(function ($item) {
            return [$item->departure_point, $item->arrival_point];
        })->unique()->values()->toArray();

        $seat_category = $suggestion->flatMap(function ($item) {
            return [$item->category];
        })->unique()->values()->toArray();

        $seat_tag = $suggestion->flatMap(function ($item) {
            return [$item->seat_tag];
        })->unique()->values()->toArray();

        $lastDateAvailable = $suggestion->max('departure_date');
        $lastDateAvailablePlusOne = \Carbon\Carbon::parse($lastDateAvailable)->addDay()->format('Y-m-d');
    

        return view('pages.dashboard.add-next-day-update-page', [
            'ship_id' => $ship_id,
            'place_suggestion' => $place_suggestion,
            'seat_category' => $seat_category,
            'seat_tag' => $seat_tag,
            'lastDateAvailable' => $lastDateAvailablePlusOne,
        ]);
    }



    function checkDuplicateDepartureDate(Request $request)
    {
        $user_id = $request->header('id'); // Ensure this header exists if required
        $departureDate = $request->input('departure_date'); // Should be a valid date
        $ship_id = $request->input('ship_id'); // Should be a valid ship ID

        // Query to check for duplicate departure dates
        $data = DB::table('ship_details')
            ->join('departure_points', 'ship_details.id', '=', 'departure_points.shipDetails_id')
            ->where([
                ['ship_details.id', '=', $ship_id],
                ['departure_points.departure_date', '=', $departureDate],
            ])
            ->count();

        return response()->json($data);
    }

    function getAvailableDates(Request $request)
    {
        $ship_id = $request->input('ship_id');

        // Fetch all assigned departure dates for the given ship
        $assignedDates = DB::table('departure_points')
            ->where('shipDetails_id', $ship_id)
            ->whereRaw("DATE(departure_date) >= ?", [Carbon::now()->format('Y-m-d')])
            ->select(
                'departure_point',
                DB::raw("DATE_FORMAT(departure_date, '%d-%m-%Y') as formatted_departure_date")
            ) // Format date
            ->get();

        return $assignedDates;
    }
    function insertAnotherDay(Request $request)
    {
        DB::beginTransaction();
        try {

            $postData = $request->all();
            $user_id = $request->header('id');
            $ship_id = $postData['ship_id'];
            // Save Ship Route (Departure and Arrival Points)
            $shipRoute = $postData['shipRoute'] ?? [];
            $departureIDs = [];
            foreach ($shipRoute as $route) {
                // Only process if departure and arrival data exist
                if (isset($route['departure_from'], $route['departure_date'], $route['departure_time'])) {
                    for ($i = 0; $i < 10; $i++) { // Loop for the next 10 days
                        // Increment departure date
                        $departureDate = new DateTime($route['departure_date']);
                        $departureDate->modify("+$i day");

                        // Save Departure Point
                        $DeparturePoint = DeparturePoint::create([
                            'shipDetails_id' => $ship_id,
                            'departure_point' => $route['departure_from'],
                            'departure_date' => $departureDate->format('Y-m-d'),
                            'departure_time' => $route['departure_time']
                        ]);
                        $departureIDs[] = $DeparturePoint->id;
                    }
                }

                // Save Arrival Point if it exists
                if (isset($route['arrival_at'], $route['arrival_time']) && $route['arrival_date']) {
                    for ($i = 0; $i < 10; $i++) {
                        // Increment arrival date if present
                        $arrivalDate = new DateTime($route['arrival_date']);
                        $arrivalDate->modify("+$i day"); //

                        $ArrivedPoint =   ArrivalPoint::create([
                            'shipDetails_id' => $ship_id,
                            'departurePoints_id' => $departureIDs[$i],
                            'arrival_point' => $route['arrival_at'],
                            'arrival_date' => $arrivalDate->format('Y-m-d'),
                            'arrival_time' => $route['arrival_time']
                        ]);

                        // Save Seat price if it exists
                        // Save Seat Map
                        $seatMapData = $postData['seatMap'] ?? [];
                        foreach ($seatMapData as $seat) {
                            $seatPrice = $postData['seatPrices'] ?? [];
                            foreach ($seatPrice as $price) {
                                if ($seat['seat_category'] == $price['seat_category'] && $route['arrival_at'] == $price['arrival_at']) {
                                    $available_seats = $seat['seat_row'] * $seat['seat_column'];
                                    SeatMap::create([
                                        'shipDetails_id' => $ship_id,
                                        'arrivalPoints_id' => $ArrivedPoint->id,
                                        'category' => $seat['seat_category'],
                                        'seat_in_rows' => $seat['seat_row'],
                                        'seat_in_columns' => $seat['seat_column'],
                                        'seat_tag' => $seat['seat_tag'],
                                        'available_seats' => $available_seats,
                                        'seat_price' => $price['seat_price']
                                    ]);
                                }
                            }
                        }
                    }
                }
            }

            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Ship data successfully saved!'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
