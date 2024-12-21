<?php

namespace App\Http\Controllers;

use App\Models\ArrivalPoint;
use App\Models\DeparturePoint;
use App\Models\RefundPolicy;
use App\Models\SeatMap;
use App\Models\ShipDetail;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class shipAssignController extends Controller
{
    //
    public function assignShip(Request $request)
    {

        DB::beginTransaction();

        try {
            $postData = $request->all();

            $user_id = $request->header('id');
            // Save Ship Details
            $shipDetails = $postData['shipDetails'][0] ?? null;
            if (!$shipDetails) {
                return response()->json(['status' => false, 'message' => 'Ship details are required']);
            }

            // Check if the ship already exists
            $shipExists = ShipDetail::where('ship_register_no', $shipDetails['ship_register_no'])->first();
            if ($shipExists) {
                return response()->json(['status' => false, 'message' => 'Ship already exists']);
            }

            $shipDetail = ShipDetail::create([
                'ship_name' => $shipDetails['ship_name'],
                'couch_no' => $shipDetails['couch_no'],
                'ship_register_no' => $shipDetails['ship_register_no'],
                'ship_manager_name' => $shipDetails['manager_name'],
                'ship_manager_number' => $shipDetails['manager_number'],
                'user_id' => $user_id // Assuming the authenticated user is assigning the ship
            ]);

            // Save Refund Policies
            $refundPolicyData = $postData['refundPolicyData'] ?? [];
            foreach ($refundPolicyData as $policy) {
                RefundPolicy::create([
                    'shipDetails_id' => $shipDetail->id,
                    'refund_category' => $policy['refund_category'],
                    'refund_time' => $policy['refund_time']
                ]);
            }


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
                            'shipDetails_id' => $shipDetail->id,
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
                            'shipDetails_id' => $shipDetail->id,
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
                                        'shipDetails_id' => $shipDetail->id,
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
