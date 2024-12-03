<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Cloudinary\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class profileController extends Controller
{

    //Get User Profile
    public function getUserProfile(Request $request)
    {
        try {
            //get user id from request header
            $id = $request->header('id');
            $user = User::find($id);
            return response()->json(['straus' => 'Success', 'user' => $user], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    //Update Users Profile
    public function updateProfile(Request $request)
    {
        try {

            //get user id from request header
            $id = $request->header('id');
            $user = User::find($id);

            //get data from users request
            $name = $request->name;
            $phone = $request->phone;
            $address = $request->address;
            $gender = $request->gender;
            $image = $request->file('image');

            // Define the custom name for the image
            $customImageName = $image->getClientOriginalName(); // Original file name

            // Upload the image to Cloudinary
            $cloudinary = new Cloudinary([
                'cloud' => [
                    'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                    'api_key' => env('CLOUDINARY_API_KEY'),
                    'api_secret' => env('CLOUDINARY_API_SECRET')
                ]
            ]);
            if ($user) {
                $uploadedFile = $cloudinary->uploadApi()->upload($image->getRealPath(), [
                    'public_id' => $customImageName // Set the custom name here
                ]);

                // Get the image URL from the response
                $imageUrl = $uploadedFile['secure_url'];
                $delete_id = $uploadedFile['public_id'];

                if ($uploadedFile) {
                    // Update data into the database
                    $user->name = $name;
                    $user->phone = $phone;
                    $user->address = $address;
                    $user->gender = $gender;
                    $user->image_Url = $imageUrl;
                    $user->delete_id = $delete_id;
                    $user->save();
                    return response()->json(['message' => 'Profile updated successfully'], 200);
                } else {
                    return response()->json(['error' => 'Image upload failed'], 500);
                }
            } else {
                return response()->json(['error' => 'User not found'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    //Delete Users Profile
    public function deleteProfile(Request $request)
    {
        try {
            //get user id from request header
            $id = $request->header('id');
            //get user data from databas
            $user = User::find($id);
            //delete image from cloudinary
            $cloudinary = new Cloudinary([
                'cloud' => [
                    'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                    'api_key' => env('CLOUDINARY_API_KEY'),
                    'api_secret' => env('CLOUDINARY_API_SECRET')
                ]
            ]);
            $cloudinary->uploadApi()->destroy($user->delete_id);
            //delete user data from database
            $user->delete();

            //if exits session then delete session
            Session::forget('user_name');
            Session::forget('user_role');

            return redirect('/')->cookie('token', '', -1);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
