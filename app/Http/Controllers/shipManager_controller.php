<?php

namespace App\Http\Controllers;

use App\Models\ArrivalPoint;
use App\Models\RefundPolicy;
use App\Models\ShipDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class shipManager_controller extends Controller
{
    //---------------------------------------- show the all ship
    function getShipList(Request $request)
    {
        $userId = $request->header('id');

        // Ensure the user is authenticated
        if (!$userId) {
            return response()->json(['error' => 'Unauthorized']);
        }

        // Fetch ship details for the authenticated user
        $ships = ShipDetail::where('user_id', $userId)->get(['id', 'ship_name', 'ship_register_no', 'couch_no']);

        // Return JSON response
        return response()->json($ships);
    }

    //--------------------------------------- delete ship full date
    function deleteShip(Request $request)
    {
        $userId = $request->header('id');
        $shipId = $request->input('ship_id');

        // Ensure the user is authenticated
        if (!$userId) {
            return response()->json(['error' => 'Unauthorized']);
        }

        try {
            // Start a database transaction
            DB::transaction(function () use ($shipId) {
                // Step 1: Delete records in seat_maps (depends on arrival_points)
                DB::table('invoices')->where('shipDetails_id', $shipId)->get()->each(function ($invoice) {
                    DB::table('invoice_seats')->where('invoice_id', $invoice->id)->delete();
                });

                DB::table('seat_maps')
                    ->whereIn('arrivalPoints_id', function ($query) use ($shipId) {
                        $query->select('id')
                            ->from('arrival_points')
                            ->where('shipDetails_id', $shipId);
                    })
                    ->delete();

                    DB::table('refund_histories')->where('shipDetails_id', $shipId)->delete();

                    DB::table('invoices')->where('shipDetails_id', $shipId)->delete();
                    
                // Step 2: Delete records in arrival_points (depends on ship_details)
                DB::table('arrival_points')->where('shipDetails_id', $shipId)->delete();

                // Step 3: Delete records in departure_points (depends on ship_details)
                DB::table('departure_points')->where('shipDetails_id', $shipId)->delete();

                // Step 4: Delete records in refund_policies (depends on ship_details)
                DB::table('refund_policies')->where('shipDetails_id', $shipId)->delete();
                
    

                // Step 5: Delete the ship from ship_details
                ShipDetail::where('id', $shipId)->delete();
            });

            // Return success message
            return response()->json(['message' => 'Ship deleted successfully']);
        } catch (\Exception $e) {
            // Return error message
            return response()->json(['message' => 'Something went wrong', 'error_message' => $e->getMessage()]);
        }
    }

    //---------------------------------------Update ship 
    public function editShip($ship_id, $updateType)
    {
        $userId = request()->header('id');

        // Ensure the user is authenticated
        if (!$userId) {
            return response()->json(['error' => 'Unauthorized']);
        }


        if ($updateType == "details") {
            $data = ShipDetail::where('id', $ship_id)->first();
        } else if ($updateType == "policy") {
            $data = RefundPolicy::where('shipDetails_id', $ship_id)->get();
        } else if ($updateType == "date_base") {
            $data = [];
        }
        // return response()->json($data);
        // Pass the route parameters to the view
        return view('pages.dashboard.ship-update-page')->with([
            'data' => $data,
            'updateType' => $updateType,
            'ship_id' => $ship_id
        ]);
    }


    //---------------------------------------------------Data Base Update

    //------------------------ findDepartureDate
    public function findDepartureDate(Request $request)
    {
        $userId = $request->header('id');
        $shipId = $request->input('ship_id');
        $departureDate = $request->input('date');

        // Ensure the user is authenticated
        if (!$userId) {
            return response()->json(['error' => 'Unauthorized']);
        }

        $departureCollection = DB::table('ship_details')
            ->join('departure_points', 'ship_details.id', '=', 'departure_points.shipDetails_id')
            ->where([
                ['ship_details.id', '=', $shipId],
                ['departure_points.departure_date', '=', $departureDate],
            ])
            ->select(
                'departure_points.id',
                'departure_points.departure_point',
                'departure_points.departure_time',
                'departure_points.departure_date',
            )
            ->get();

        return response()->json($departureCollection);
    }
    //---------------------------------------- findDepartureBaseData
    public function findDepartureBaseData($ship_id, $updateType, $departure_id)
    {
        //---route data
        // Fetch route data
        $data = DB::table('ship_details')
            ->join('departure_points', 'ship_details.id', '=', 'departure_points.shipDetails_id')
            ->join('arrival_points', 'departure_points.id', '=', 'arrival_points.departurePoints_id')
            ->join('seat_maps', 'arrival_points.id', '=', 'seat_maps.arrivalPoints_id')
            ->where([
                ['ship_details.id', '=', $ship_id],
                ['departure_points.id', '=', $departure_id]
            ])
            ->select(
                'ship_details.id as ship_id',
                'ship_details.ship_name',
                'ship_details.couch_no',
                'departure_points.id as departure_point_id',
                'departure_points.departure_point',
                'departure_points.departure_time',
                'departure_points.departure_date',
                'arrival_points.id as arrival_point_id',
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
            ->get();

        // Group and structure the data for the view
        $groupedRoutes = $data->groupBy('departure_point')->map(function ($routeGroup) {
            $departure = $routeGroup->first();
            $arrivalPoints = $routeGroup->map(function ($route) {
                return [
                    'arrival_point_id' => $route->arrival_point_id,
                    'arrival_point' => $route->arrival_point,
                    'arrival_time' => $route->arrival_time,
                    'arrival_date' => $route->arrival_date,
                ];
            })->unique();

            return [
                'ship_id' => $departure->ship_id,
                'ship_name' => $departure->ship_name,
                'departure_point_id' => $departure->departure_point_id,
                'departure_point' => $departure->departure_point,
                'departure_time' => $departure->departure_time,
                'departure_date' => $departure->departure_date,
                'arrival_points' => $arrivalPoints,
            ];
        });

        //---seat map data
        $groupedSeats = $data->groupBy('category')->map(function ($seatGroup) {
            return [
                'category' => $seatGroup->first()->category,
                'seats' => $seatGroup->map(function ($seat) {
                    return [
                        'seat_map_id' => $seat->seat_map_id,
                        'category' => $seat->category,
                        'seat_in_rows' => $seat->seat_in_rows,
                        'seat_in_columns' => $seat->seat_in_columns,
                        'seat_tag' => $seat->seat_tag
                    ];
                })->unique(function ($seat) {
                    // Define uniqueness criteria here
                    return $seat['seat_tag']; // You can use another key, like 'seat_tag', if needed
                })->values(), // Re-index the array after filtering
            ];
        });
        //--- seat map price
        $groupedSeatPrice = $data->groupBy('arrival_point')->map(function ($seatGroup) {
            return [
                'arrival_point_id' => $seatGroup->first()->arrival_point_id,
                'arrival_point' => $seatGroup->first()->arrival_point,
                'seat_price' => $seatGroup->map(function ($seat) {
                    return [
                        'seat_map_id' => $seat->seat_map_id,
                        'category' => $seat->category,
                        'seat_price' => $seat->seat_price,
                    ];
                })->unique(function ($seat) {
                    // Define uniqueness criteria here
                    return $seat['category']; // You can use another key, like 'category', if needed
                })->values(), // Re-index the array after filtering
            ];
        });


        // return response()->json(['routes' => $groupedRoutes->values(), 'seat_maps' => $groupedSeats->values() , 'seat_price' => $groupedSeatPrice->values()]);
        // Return the data to the view
        return view('pages.dashboard.ship-update-page2', [
            'routes' => $groupedRoutes->values(),
            'seat_maps' => $groupedSeats->values(),
            'seat_price' => $groupedSeatPrice->values(),
        ]);
    }
    function getAllShips(Request $request){
        $userId = $request->header('id');
        // Ensure the user is authenticated
        if (!$userId) {
            return response()->json(['error' => 'Unauthorized']);
        }
        $ships = ShipDetail::all();
        return response()->json($ships);
    }
}
