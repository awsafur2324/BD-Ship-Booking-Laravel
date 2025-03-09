<?php

namespace App\Http\Controllers;

use App\Helper\sslCommerce;
use App\Models\Invoice;
use App\Models\InvoiceSeat;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class booking_invoice_controller extends Controller
{
    //
    public function booking_create_invoice(Request $request)
    {
        DB::beginTransaction();

        try {
            // Validate request
            $request->validate([
                'selectedSeats' => 'required|array',
                'discount.discount_id' => 'nullable|integer',
                'discount.discount_percentage' => 'nullable|numeric',
                'shipDetails_id' => 'required|integer',
            ]);

            $user_id = $request->header('id');
            $user_email = $request->header('email');
            $selectedSeats = $request->input('selectedSeats');
            $discount = $request->input('discount');
            $shipDetails_id = $request->input('shipDetails_id');
            $departurePoints_id = $request->input('departurePoints_id');

            if (!$user_id || !$user_email) {
                throw new Exception("User information is missing.");
            }

            $tran_id = uniqid();
            $delivery_status = 'Pending';
            $payment_status = 'Pending';

            // Fetch user details
            $user = User::findOrFail($user_id);
            $cus_details = "Name: $user->name, Address: $user->address, City: $user->city, Phone: $user->phone";

            // Calculate total and apply discount
            $total = 0;
            foreach ($selectedSeats as $seat) {
                $total += $seat['seat_price'];
            }
            $discount_percentage = $discount['discount_percentage'] ?? 0;
            $discount_amount = ($total * $discount_percentage) / 100;
            $payable = $total - $discount_amount;

            // Create invoice
            $invoice = Invoice::create([
                'total' => $total,
                'payable' => $payable,
                'cus_details' => $cus_details,
                'tran_id' => $tran_id,
                'delivery_status' => $delivery_status,
                'payment_status' => $payment_status,
                'user_id' => $user_id,
                'shipDetails_id' => $shipDetails_id,
                'discount_id' => $discount['discount_id'] ?? 0,
                'departure_id' => $departurePoints_id,
            ]);

            // Add seats to invoice
            foreach ($selectedSeats as $seat) {
                InvoiceSeat::create([
                    'seat_tag' => $seat['seat_tag'],
                    'seat_price' => $seat['seat_price'],
                    'discount_price' => $seat['seat_price'] - (($seat['seat_price'] * $discount_percentage) / 100),
                    'seatMap_id' => $seat['Seat_map_id'],
                    'invoice_id' => $invoice->id,
                    'user_id' => $user_id,
                ]);
            }

            // Initiate payment
            $profile = [
                "cus_name" => $user->name,
                "cus_add" => $user->address ?? 'Dhaka', // Default to 'Dhaka' if empty
                "cus_city" => $user->city ?? 'Dhaka',  // Default to 'Dhaka' if empty
                "cus_country" => "Bangladesh",
                "cus_phone" => $user->phone,
                "ship_name" => $user->name,
                "ship_add" => $user->address ?? 'Dhaka', // Default to 'Dhaka' if empty
                "ship_city" => $user->city ?? 'Dhaka',  // Default to 'Dhaka' if empty
                "ship_country" => 'Bangladesh',
            ];
            $paymentMethod = sslCommerce::InitiatePayment($profile, $payable, $tran_id, $user_email);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Invoice created successfully.',
                'data' => [
                    'paymentMethod' => $paymentMethod,
                    'payable' => $payable,
                    'total' => $total,
                    'discount' => $discount_amount,
                ],
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function InvoiceList(Request $request)
    {
        $user_id = $request->header('id');
        return Invoice::where('user_id', $user_id)->get();
    }

    public function InvoiceSeatList(Request $request)
    {
        $user_id = $request->header('id');
        $invoice_id = $request->invoice_id;
        return InvoiceSeat::where(['user_id' => $user_id, 'invoice_id' => $invoice_id])
            ->with('product')
            ->get();
    }

    public function PaymentSuccess(Request $request)
    {
        sslCommerce::InitiateSuccess($request->query('tran_id'));
        return redirect('/dashboard/my-Bookings');
    }

    public function PaymentCancel(Request $request)
    {
        sslCommerce::InitiateCancel($request->query('tran_id'));
        return redirect('/find-destination');
    }

    public function PaymentFail(Request $request)
    {
        sslCommerce::InitiateFail($request->query('tran_id'));
        return redirect('/find-destination');
    }

    public function PaymentIPN(Request $request)
    {
        return sslCommerce::InitiateIPN(
            $request->input('tran_id'),
            $request->input('status'),
            $request->input('val_id')
        );
    }
}
