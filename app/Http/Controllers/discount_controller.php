<?php

namespace App\Http\Controllers;

use App\Models\AddDiscount;
use App\Models\User;
use Cloudinary\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class discount_controller extends Controller
{
    //
    function addDiscount(Request $request)
    {
        try {
            $user_id = $request->header('id');
            $image = $request->file('discount_img');

            if (!$image) {
                return response()->json([
                    'success' => false,
                    'message' => 'No image uploaded.'
                ]);
            }

            // Check for duplicate coupon codes
            $coupon_code = $request->coupon_code;
            $discount = AddDiscount::where('coupon_code', $coupon_code)
                ->where('discount_status', 'active')
                ->first();

            if ($discount) {
                return response()->json([
                    'success' => false,
                    'message' => 'Coupon code already exists. Pick another one.',
                ]);
            }

            // Upload the image to Cloudinary
            $customImageName = $image->getClientOriginalName();
            $cloudinary = new Cloudinary([
                'cloud' => [
                    'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                    'api_key' => env('CLOUDINARY_API_KEY'),
                    'api_secret' => env('CLOUDINARY_API_SECRET')
                ]
            ]);
            $uploadedFile = $cloudinary->uploadApi()->upload($image->getRealPath(), [
                'public_id' => $customImageName
            ]);

            $imageUrl = $uploadedFile['secure_url'];

            // Save discount to the database
            AddDiscount::create([
                'discount_title' => $request->discount_title,
                'coupon_code' => $request->coupon_code,
                'startDate' => $request->startDate,
                'finishDate' => $request->finishDate,
                'discount_percentage' => $request->discount_percentage,
                'discountImg' => $imageUrl,
                'discount_status' => 'active',
                'discount_description' => $request->discount_description ?? '',
                'user_id' => $user_id,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Discount added successfully.',
            ]);
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Add Discount Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred. Please try again later.',
                'error' => $e->getMessage(), // Include this in dev mode only
            ]);
        }
    }

    function getDiscount()
    {
        $discounts = AddDiscount::where('discount_status', 'active')->get();
        return view('pages.app.home-page')->with('discounts', $discounts);
    }

    //discount table
    function getDiscountTable(Request $request)
    {
        $user_id = $request->header('id');
        //confirm if user is admin or not
        $user = User::find($user_id);
        if ($user->role == 'admin') {
            $data = AddDiscount::where('discount_status', '!=', 'fixed')->get();
            return response()->json([
                'success' => true,
                'data' => $data,
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'You are not authorized to access this page',
        ]);
    }

    //inactiveDiscount
    function inactiveDiscount(Request $request)
    {
        $id = $request->id;
        $user_id = $request->header('id');
        //confirm if user is admin or not
        $user = User::find($user_id);
        if ($user->role == 'admin') {
            $discount = AddDiscount::find($id);
            $discount->discount_status = 'inactive';
            $discount->save();
            return response()->json([
                'success' => true,
                'message' => 'Discount has been deactivated successfully.',
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'You are not authorized to access this page',
        ]);
    }

    //editPageShow
    public function editPageShow(Request $request, $id)
    {
        $user_id = $request->header('id');
        //confirm if user is admin or not
        $user = User::find($user_id);
        if ($user->role == 'admin') {
            $discount = AddDiscount::find($id);
            return view('pages.dashboard.discount-edit')->with('discount', $discount);
        }
        return response()->json([
            'success' => false,
            'message' => 'You are not authorized to access this page',
        ]);
    }

    //updateDiscount
    public function updateDiscount(Request $request)
    {
        try {
            $user_id = $request->header('id');
            $image = $request->file('discount_img');
            $discount_id = $request->discount_id;
    
            // Check for duplicate coupon codes
            $coupon_code = $request->coupon_code;
            $discount = AddDiscount::where('coupon_code', $coupon_code)
                ->where('discount_status', 'active')
                ->where('id', '!=', $discount_id)
                ->count();
    
            if ($discount > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Coupon code already exists. Pick another one.',
                ]);
            }
    
            // Check if discount record exists
            $discountRecord = AddDiscount::find($discount_id);
            if (!$discountRecord) {
                return response()->json([
                    'success' => false,
                    'message' => 'Discount not found.',
                ]);
            }
    
            // If a new image is uploaded, upload it to Cloudinary
            if ($image) {
                $customImageName = $image->getClientOriginalName();
                $cloudinary = new Cloudinary([
                    'cloud' => [
                        'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                        'api_key' => env('CLOUDINARY_API_KEY'),
                        'api_secret' => env('CLOUDINARY_API_SECRET')
                    ]
                ]);
                $uploadedFile = $cloudinary->uploadApi()->upload($image->getRealPath(), [
                    'public_id' => $customImageName
                ]);
    
                $imageUrl = $uploadedFile['secure_url'];
            }
    
            // Update the discount record
            $discountRecord->update([
                'discount_title' => $request->discount_title,
                'coupon_code' => $request->coupon_code,
                'startDate' => $request->startDate,
                'finishDate' => $request->finishDate,
                'discount_percentage' => $request->discount_percentage,
                'discountImg' => isset($imageUrl) ? $imageUrl : $discountRecord->discountImg, // Keep existing image if no new one
                'discount_status' => 'active',
                'discount_description' => $request->discount_description ?? '',
                'user_id' => $user_id,
            ]);
    
            return response()->json([
                'success' => true,
                'message' => 'Discount updated successfully.',
            ]);
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Update Discount Error: ' . $e->getMessage());
    
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred. Please try again later.',
                'error' => $e->getMessage(), // Include this in dev mode only
            ]);
        }
    }
    
}
