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
            // Validate the incoming request

            // Retrieve user ID from the request header
            $id = $request->header('id');
            $user = User::find($id);

            // Check if user exists
            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }

            // Update basic profile information
            $user->name = $request->name ?? '';
            $user->phone = $request->phone ?? '';
            $user->gender = $request->gender ?? '';
            $user->address = $request->address ?? '';
            $user->city = $request->city ?? '';
            $user->country = $request->country ?? '';

            // Handle image upload if provided
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $customImageName = $image->getClientOriginalName();
                // Define Cloudinary instance
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
                    $imageUrl  = $uploadedFile['secure_url'];
                    $delete_id  = $uploadedFile['public_id'];
                    $user->image_Url = $imageUrl;
                    $user->delete_id = $delete_id;
                }
            }

            // Save user updates to the database
            $user->save();

            return response()->json(['message' => 'Profile updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
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

    public function getManagerStatus(Request $request)
    {
        $user_id = $request->header('id');
        $user = User::where('id', $user_id)->first();
        return response()->json([$user]);
    }

    public function changeManager_status(Request $request)
    {
        $user_id = $request->header('id');
        $user = User::where('id', $user_id)->update(['manager_status' => 'pending']);
        return response()->json(['success' => true, 'message' => 'Manager status changed successfully'], 200);
    }
    function getManagersRequests(Request $request)
    {
        $User = User::where('manager_status', 'pending')->get();
        return response()->json(['success' => true, 'data' => $User], 200);
    }
    function acceptManagerRequest(Request $request)
    {
        $user_id = $request->input('user_id');
        User::where('id', $user_id)->update(['manager_status' => 'active', 'role' => 'manager', 'manager_verified' => "true"]);

        return response()->json(['success' => true, 'data' => 'Manager request accepted successfully']);
    }
    function rejectManagerRequest(Request $request)
    {
        $user_id = $request->input('user_id');
        User::where('id', $user_id)->update(['manager_status' => 'inactive', 'role' => 'user', 'manager_verified' => ""]);

        return response()->json(['success' => true, 'data' => 'Manager request accepted successfully']);
    }
    function getAllManagers(Request $request)
    {
        $User = User::where('role', 'manager')->where('manager_verified', 'true')->get();
        return response()->json(['success' => true, 'data' => $User]);
    }

    function profilePageShow(Request $request)
    {
        $user_id = $request->header('id');
        $user = User::where('id', $user_id)->first();
        return view('pages.dashboard.profile-page', compact('user'));
    }
}
