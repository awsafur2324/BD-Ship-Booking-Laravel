<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Booking;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class bookingController extends Controller
{
    //
    public function shipView($id, $departure_id)
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
        if ($shipDetails->isEmpty()) {
            return response()->json(['status' => 'error', 'message' => 'Ship not found']);
        }
        // return $user;
        return view('pages.app.booking-page', ['shipDetails' => $shipDetails, 'user' => $user]);
    }

    // set the booking data to the database
    public function setBookingData(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'selectedSeats' => 'required|array',
            'selectedSeats.*.seat_tag' => 'required|string',
            'selectedSeats.*.seat_price' => 'required|numeric',
            'selectedSeats.*.seat_category' => 'required|string',
            'selectedSeats.*.user_id' => 'required|exists:users,id',
            'selectedSeats.*.shipDetails_id' => 'required|exists:ship_details,id',
            'selectedSeats.*.departurePoints_id' => 'required|exists:departure_points,id',
            'selectedSeats.*.Seat_map_id' => 'required|exists:seat_maps,id',
        ]);
        try {
            // Loop through the selected seats and create booking records
            foreach ($validatedData['selectedSeats'] as $seat) {
                Booking::create([
                    'seat_tag' => $seat['seat_tag'],
                    'seat_price' => $seat['seat_price'],
                    'seat_category' => $seat['seat_category'],
                    'user_id' => $seat['user_id'],
                    'shipDetails_id' => $seat['shipDetails_id'],
                    'departurePoints_id' => $seat['departurePoints_id'],
                    'Seat_map_id' => $seat['Seat_map_id'],
                ]);
            }

            // Return a success response
            return response()->json([
                'status' => 'success',
                'message' => 'Seats booked successfully!',
            ]);
        } catch (\Exception $e) {
            // Return a failure response
            return response()->json([
                'status' => 'error',
                'message' => 'There was an error while booking seats: ' . $e->getMessage(),
            ]);
        }
    }

    function viewBookings(Request $request)
    {
        // Get user ID from request header
        $user_id = $request->header('id');
        if (!$user_id) {
            return response()->json(['status' => 'error', 'message' => 'User ID not provided'], 400);
        }

        // Fetch bookings with joins
        $bookings = DB::table('booking')
            ->join('ship_details', 'booking.shipDetails_id', '=', 'ship_details.id')
            ->join('departure_points', 'booking.departurePoints_id', '=', 'departure_points.id')
            ->where('booking.user_id', $user_id)
            ->select(
                'booking.id as No',
                'ship_details.ship_name',
                'departure_points.departure_point',
                'booking.seat_tag as seats',
                'booking.seat_price as price',
                'ship_details.ship_manager_name',
                'ship_details.ship_manager_number as ship_manager_mobile'
            )
            ->get();

        // Group bookings by ship_name
        $groupedData = $bookings->groupBy('ship_name')->map(function ($group, $ship_name) {
            return [
                'ship_name' => $ship_name,
                'ship_manager_name' => $group->first()->ship_manager_name,
                'ship_manager_mobile' => $group->first()->ship_manager_mobile,
                'departure_point' => $group->first()->departure_point,
                'bookings' => $group->map(function ($booking) {
                    return [
                        'No' => $booking->No,
                        'seats' => $booking->seats,
                        'price' => $booking->price,
                    ];
                })->values(),
            ];
        })->values();

        // Return the grouped data as a JSON response
        return response()->json([
            'status' => 'success',
            'data' => $groupedData,
        ]);
    }
}
