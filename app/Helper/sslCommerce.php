<?php

namespace App\Helper;

use App\Models\Invoice;
use App\Models\InvoiceSeat;
use App\Models\SeatMap;
use App\Models\SslcommerzAccount;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class sslCommerce
{
    public static function InitiatePayment($Profile, $payable, $tran_id, $user_email): array
    {
        try {
            $ssl = SslcommerzAccount::first(); // Get SSLCommerz account details

            // Send a form request to SSLCommerz through the init_url
            $response = Http::asForm()->post($ssl->init_url, [
                "store_id" => $ssl->store_id,
                "store_passwd" => $ssl->store_passwd,
                "total_amount" => $payable,
                "currency" => $ssl->currency,
                "tran_id" => $tran_id,
                "success_url" => "$ssl->success_url?tran_id=$tran_id",
                "fail_url" => "$ssl->fail_url?tran_id=$tran_id",
                "cancel_url" => "$ssl->cancel_url?tran_id=$tran_id",
                "ipn_url" => $ssl->ipn_url,
                "cus_name" => $Profile['cus_name'],
                "cus_email" => $user_email,
                "cus_add1" => $Profile['cus_add'],
                "cus_add2" => $Profile['cus_add'],
                "cus_city" => $Profile['cus_city'],
                "cus_state" => $Profile['cus_city'],
                "cus_postcode" => "1200",
                "cus_country" => $Profile['cus_country'],
                "cus_phone" => $Profile['cus_phone'],
                "cus_fax" => $Profile['cus_phone'],
                "shipping_method" => "YES",
                "ship_name" => $Profile['ship_name'],
                "ship_add1" => "Dhaka",
                "ship_add2" => "Dhaka",
                "ship_city" => "Dhaka",
                "ship_state" => "Dhaka",
                "ship_country" => "Bangladesh",
                "ship_postcode" => "12000",
                "product_name" => "BD Ship Booking seat",
                "product_category" => "Seat Booking",
                "product_profile" => "Seat",
                "product_amount" => $payable,
            ]);

            return $response->json(); // Return the JSON response as an array
        } catch (Exception $e) {
            // Return an error message as an array
            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }
    }

    static function InitiateSuccess($tran_id): int
    {
        // Update the payment status of the invoice to 'Success'
        Invoice::where(['tran_id' => $tran_id, 'val_id' => 0])->update(['payment_status' => 'Success']);

        // Retrieve the invoice ID based on the transaction ID
        $Invoice_id = Invoice::where('tran_id', '=', $tran_id)->select('id')->first();

        if ($Invoice_id) {
            // Get the seatMap_ids associated with the invoice
            $seatMapIDs = InvoiceSeat::where('invoice_id', '=', $Invoice_id->id)
                ->select('seatMap_id')
                ->get();

            // Iterate over each seatMap_id and update the available_seats
            foreach ($seatMapIDs as $seatMapID) {
                // Find the SeatMap record using seatMap_id
                $seatMap = SeatMap::find($seatMapID->seatMap_id);

                if ($seatMap) {
                    // Update the available_seats field
                    // You can reduce the available seats or set it based on business logic
                    // For example, reduce by 1 to indicate a seat has been booked
                    $seatMap->available_seats -= 1;  // Decrease available seats by 1
                    $seatMap->save();  // Save the changes
                }
            }
        } else {
            // If no invoice is found, return an empty collection (no seatMap updates)
            $seatMapIDs = collect();
        }
        return 1;
    }

    static function InitiateFail($tran_id): int
    {
        Invoice::where(['tran_id' => $tran_id, 'val_id' => 0])->update(['payment_status' => 'Fail']);
        return 1;
    }

    static function InitiateCancel($tran_id): int
    {
        Invoice::where(['tran_id' => $tran_id, 'val_id' => 0])->update(['payment_status' => 'Cancel']);
        return 1;
    }

    static function InitiateIPN($tran_id, $status, $val_id): int
    {
        Invoice::where(['tran_id' => $tran_id, 'val_id' => 0])->update(['payment_status' => $status, 'val_id' => $val_id]);
        return 1;
    }

    public static function InitiateRefund($tran_id, $refund_amount, $refund_reason): array
    {
        try {
            // Retrieve SSLCommerz account credentials
            $ssl = SslcommerzAccount::first();

            if (!$ssl) {
                return [
                    'error' => true,
                    'message' => 'SSLCommerz account details not found.',
                ];
            }

            // Define the Refund API URL
            $refund_url = 'https://sandbox.sslcommerz.com/validator/api/merchantTransIDvalidationAPI.php';

            // Prepare refund data
            $refund_data = [
                'tran_id' => $tran_id,
                'store_id' => $ssl->store_id,
                'store_passwd' => $ssl->store_passwd,
                'format' => 'json', // Response format
            ];
            // Build the query string
            $query_string = http_build_query($refund_data);
            // Send the refund request to SSLCommerz using Laravel's Http client
            $response = Http::get("{$refund_url}?{$query_string}");

            // Check if the response is successful
            if ($response->ok()) {
                $responseData = $response->json();
                if (isset($responseData['APIConnect']) && $responseData['APIConnect'] == 'DONE') {
                    if (isset($responseData['element'])) {
                        foreach ($responseData['element'] as $t) {

                            $bank_tran_id = $t['bank_tran_id'];

                            // Prepare refund data
                            $refund_info = [
                                'bank_tran_id' => $bank_tran_id,
                                'refund_amount' => $refund_amount,
                                'refund_remarks' => $refund_reason,
                                'store_id' => $ssl->store_id,
                                'store_passwd' => $ssl->store_passwd,
                                'v' => 1,
                                'format' => 'json', // Response format
                            ];

                            $query_string2 = http_build_query($refund_info);
                            $response = Http::get("{$refund_url}?{$query_string2}");

                            if ($response->ok()) {
                                $result = $response->json();
                                Log::info('Refund proper api', ['response_data' => $result]);
                                if(isset($result['status']) == 'SUCCESS'){
                                    return [
                                       'success' => true,
                                       'message' => 'Refund successful.',
                                    ];
                                }

                            }
                        }
                    }
                }
                return [
                    'success' => false,
                    'message' => 'SSlCommerz refund response error.',
                ];
            }

            return [
                'success' => false,
                'message' => 'Failed to connect to SSLCommerz.',
            ];
        } catch (Exception $e) {
            // Log exceptions for debugging
            Log::error('Refund API Exception', ['error_message' => $e->getMessage()]);

            return [
                'error' => true,
                'message' => $e->getMessage(),
            ];
        }
    }
}
