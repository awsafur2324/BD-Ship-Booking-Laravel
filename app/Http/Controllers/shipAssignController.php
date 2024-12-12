<?php

namespace App\Http\Controllers;

use App\Models\ArrivalPoint;
use App\Models\DeparturePoint;
use App\Models\RefundPolicy;
use App\Models\SeatMap;
use App\Models\ShipDetail;
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
            return $postData;

            $user_id = $request->header('id');
            // Save Ship Details
            $shipDetails = $postData['shipDetails'][0] ?? null;
            if (!$shipDetails) {
                return response()->json(['status' => false ,'message' => 'Ship details are required'], 400);
            }

            // Check if the ship already exists
            $shipExists = ShipDetail::where('ship_register_no', $shipDetails['ship_register_no'])->first();
            if ($shipExists) {
                return response()->json([ 'status' => false ,'message' => 'Ship already exists'], 400);
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
            foreach ($shipRoute as $route) {
                if (isset($route['departure_from'])) {
                   $DeparturePoint = DeparturePoint::create([
                        'shipDetails_id' => $shipDetail->id,
                        'departure_point' => $route['departure_from'],
                        'departure_date' => $route['departure_date'],
                        'departure_time' => $route['departure_time']
                    ]);
                }
                if (isset($route['arrival_at'])) {
                    ArrivalPoint::create([
                        'shipDetails_id' => $shipDetail->id,
                        'departurePoints_id' => $DeparturePoint->id,
                        'arrival_point' => $route['arrival_at'],
                        'arrival_date' => $route['arrival_date'],
                        'arrival_time' => $route['arrival_time']
                    ]);
                }
            }

            // Save Seat Map
            $seatMapData = $postData['seatMap'] ?? [];
            foreach ($seatMapData as $seat) {
                SeatMap::create([
                    'departurePoints_id' => $DeparturePoint->id,
                    'shipDetails_id' => $shipDetail->id,
                    'category' => $seat['seat_category'],
                    'seat_in_rows' => $seat['seat_row'],
                    'seat_in_columns' => $seat['seat_column'],
                    'seat_price' => $seat['seat_price'],
                    'seat_tag' => $seat['seat_tag'],
                ]);
            }
            DB::commit();

            return response()->json(['status' => true ,'message' => 'Ship data successfully saved!'], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
