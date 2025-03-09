<?php

namespace App\Http\Controllers;

use App\Models\ArrivalPoint;
use App\Models\DeparturePoint;
use App\Models\RefundPolicy;
use App\Models\SeatMap;
use App\Models\ShipDetail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use function Laravel\Prompts\select;

class shipUpdate_controller extends Controller
{
    //
    function updateShipDetails(Request $request)
    {
        try {
            $ship_id = $request->input('ship_id');
            // Find the ShipDetail record by ID
            $shipDetail = ShipDetail::findOrFail($ship_id);

            // Update the record with validated data
            $shipDetail->update([
                'ship_name' => $request->input('ship_name'),
                'couch_no' => $request->input('couch_no'),
                'ship_register_no' => $request->input('ship_register_no'),
                'ship_manager_name' => $request->input('manager_name'),
                'ship_manager_number' => $request->input('manager_number'),
            ]);
            return response()->json(['success' => true]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    function updateRefundPolicy(Request $request)
    {
        try {
            $refundPolicies = $request->input('refundPolicies');

            foreach ($refundPolicies as $policy) {
                // Check if policy ID exists or it's a new policy
                if (isset($policy['id']) && $policy['shipDetailsId']) {
                    // Update existing refund policy
                    $existingPolicy = RefundPolicy::find($policy['id']);
                    if ($existingPolicy) {
                        $existingPolicy->update([
                            'refund_category' => $policy['refundCategory'],
                            'refund_time' => $policy['refundTime'],
                            'shipDetails_id' => $policy['shipDetailsId'],
                        ]);
                    }
                } else {
                    // Create a new refund policy
                    RefundPolicy::create([
                        'refund_category' => $policy['refundCategory'],
                        'refund_time' => $policy['refundTime'],
                        'shipDetails_id' => $policy['shipDetailsId'],
                    ]);
                }
            }

            return response()->json(['success' => true]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    //update departure based

    public function updateDepartureBased(Request $request)
    {
        $shipRoutes = $request->input('shipRoute');
        $arrivalPoints = $request->input('arrivalPoints');
        $combinedData = $request->input('combinedData');

        try {

            // Update Departure Points
            foreach ($shipRoutes as $route) {
                DeparturePoint::where('id', $route['departure_point_id'])
                    ->update([
                        'departure_point' => $route['departure_from'],
                        'departure_date' => $route['departure_date'],
                        'departure_time' => $route['departure_time'],
                    ]);
            }

            // Update Arrival Points
            foreach ($arrivalPoints as $arrival) {
                ArrivalPoint::where('id', $arrival['arrival_point_id'])
                    ->update([
                        'arrival_point' => $arrival['arrival_at'],
                        'arrival_date' => $arrival['arrival_date'],
                        'arrival_time' => $arrival['arrival_time'],
                    ]);
            }

            // Update Seat Maps
            foreach ($combinedData as $seat) {
                SeatMap::where('id', $seat['seat_map_id'])
                    ->update([
                        'category' => $seat['seat_category'],
                        'seat_in_rows' => $seat['seat_row'],
                        'seat_in_columns' => $seat['seat_column'],
                        'seat_tag' => $seat['seat_tag'],
                        'seat_price' => $seat['seat_price'],
                        'available_seats' => $seat['seat_row'] * $seat['seat_column'],
                    ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Ship details updated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating ship details.',
                'error' => $e->getMessage()
            ]);
        }
    }
    function banDepartureRoute(Request $request, $departure_id)
    {
        try {
            DB::table('departure_points')
                ->where('id', $departure_id)
                ->update([
                    'status' => 'banned',
                    'updated_at' => now('Asia/Dhaka'), // Keep updated_at updated
                    'departure_date' => DB::raw('departure_date') // Prevent departure_date change
                ]);

            return response()->json(['success' => true]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    function getBanShipList(Request $request)
    {
        $user_id = $request->header('id');
        $departure_points = DB::table('departure_points')
            ->join('ship_details', 'departure_points.shipDetails_id', '=', 'ship_details.id')
            ->where('departure_points.status', 'banned')
            ->where('ship_details.user_id', $user_id)
            ->select(
                'departure_points.id',
                'departure_points.departure_point',
                'departure_points.departure_date',
                'departure_points.departure_time',
                'departure_points.status',
                'ship_details.ship_name',
                'ship_details.ship_register_no',
                'ship_details.couch_no'
            )
            ->get();

        return response()->json(['departure_points' => $departure_points]);
    }

    function activateBannedRoute(Request $request)
    {
        $departure_id = $request->input('ship_id');
        $user_id = $request->header('id');
        if ($user_id) {
            DB::table('departure_points')
                ->where('id', $departure_id)
                ->update([
                    'status' => 'active',
                    'updated_at' => now('Asia/Dhaka'), // Keep updated_at updated
                    'departure_date' => DB::raw('departure_date') // Prevent departure_date change
                ]);

            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'error' => 'User not found.']);
        }
    }
}
