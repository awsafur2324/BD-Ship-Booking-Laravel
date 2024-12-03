<?php

namespace App\Http\Controllers\auth;

use App\Helper\JWT_token;
use App\Helper\otp_sent;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class userController extends Controller
{

    // Register
    public function register(Request $request)
    {
        try {
            // set the email 
            $email = $request->email;
            $user = User::where('email', $email)->first();
            if ($user && $user->email_verified === 'true') {
                return response()->json(['status' => false, 'message' => 'Email already exists'], 500);
            } else {
                if ($user) {
                    // delete user from database if email already exists
                    User::where('email', $email)->delete();
                }
                // Hash password
                $password = Hash::make($request->password);


                // Insert data into database
                User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => $password,
                    'phone' => $request->phone,
                    'role' => $request->role,
                ]);

                // set data into session so that use it Email_verifyOtp
                $request->session()->put('email', $email);

                // send email to user with OTP
                $status =  otp_sent::otpSent($email, 'register_verification_otp');

                if ($status == true) {
                    //TODO :: Redirect to OTP Input page

                    return response()->json(['status' => true,  'message' => 'Please Check Your Email.'], 200);
                } else {
                    // delete user from database if email sent failed
                    User::where('email', $email)->delete();
                    return response()->json(['status' => false, 'message' => 'Registration failed'], 500);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Registration failed'], 500);
        }
    }

    // Registration verification with OTP
    public function Email_verifyOtp(Request $request)
    {
        try {
            $otp = $request->otp;
            $email = $request->session()->get('email');
            $user = User::where('email', $email)->first();
            if ($user->otp == $otp) {

                //update pass and the otp to 0
                User::where('email', '=', $email)->update(['email_verified' => 'true', 'otp' => 0]);

                //Generate token
                $token = JWT_token::CreateToken($user->email, $user->id);

                // set user role into session so that use it in anywhere.
                $request->session()->put('user_role', $user->role);
                $request->session()->put('user_name', $user->name);

                // Redirect to current page
                return response()->json([
                    'status' => 'success',
                    'message' => 'Registration successful',
                ], 200)->cookie('token', $token, time() + 60 * 60 * 24 * 30); // 30 days for client site
            } else {
                // remove email from session if otp is not match
                $request->session()->forget('email');
                // delete user from database if otp is not match
                User::where('email', $email)->delete();
                // TODO :: Redirect to Register page with error message

                return response()->json(['status' => false, 'message' => 'Registration failed'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Registration failed'], 500);
        }
    }

    // Log in 
    public function login(Request $request)
    {
        try {
            $email = $request->email;
            $user = User::where('email', $email)->first();
            if ($user && $user->email_verified === 'true') {
                if (Hash::check($request->password, $user->password)) {
                    //Generate token
                    $token = JWT_token::CreateToken($user->email, $user->id);

                    // set user role into session so that use it in anywhere.
                    $request->session()->put('user_role', $user->role);
                    $request->session()->put('user_name', $user->name);

                    // Redirect to current page
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Login successful',
                    ], 200)->cookie('token', $token, time() + 60 * 60 * 24 * 30); // 30 days for client site
                } else {
                    return response()->json(['status' => false, 'message' => 'Invalid password'], 500);
                }
            } else {
                // delete user from database if email not verified
                User::where('email', $email)->delete();
                return response()->json(['status' => false, 'message' => 'Invalid email or email not verified . Register again'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Login failed'], 500);
        }
    }

    // Forgot Password send OTP
    public function forgotPassword_sendOtp(Request $request)
    {
        try {
            $email = $request->email;
            $user = User::where('email', $email)->first();
            if ($user) {
                // Generate OTP
                // send email to user with OTP
                $status =  otp_sent::otpSent($email, 'forgot_password_verification_otp');

                if ($status == true) {

                    // set token for otp verification
                    $token = JWT_token::ForgetPasswordToken($user->email);

                    return response()->json(['status' => true,  'message' => 'OTP sent successfully.'], 200)->cookie('forgot_password_token', $token, time() + 60 * 20); // 20 minutes for otp verification
                } else {
                    return response()->json(['status' => false, 'message' => 'OTP sent failed.'], 500);
                }
            } else {
                return response()->json(['status' => false, 'message' => 'Invalid email'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Try again later.Something went wrong'], 500);
        }
    }

    // Forgot Password verify OTP
    public function forgotPassword_verifyOtp(Request $request)
    {
        try {
            $otp = $request->otp;
            $email = $request->header('email'); // get email from header which is set by middleware
            $user = User::where('email', $email)->first();
            if ($user->otp == $otp) {
                //update the otp to 0
                User::where('email', '=', $email)->update(['otp' => 0]);

                return response()->json(['status' => true,  'message' => 'OTP verified.'], 200);

                //ToDO : redirect to reset password page (frontend)

            } else {
                return response()->json(['status' => false, 'message' => 'Invalid OTP'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Try again later.Something went wrong'], 500);
        }
    }

    // Reset Password
    public function resetPassword(Request $request)
    {
        try {
            $newPassword = Hash::make($request->new_password);
            $email = $request->header('email');
            User::Where('email', $email)->update(['password' => $newPassword]);
            // TODO :: Redirect to login page with success message
            return response()->json(['status' => true,  'message' => 'Password reset successful.'], 200)->cookie('forgot_password_token', '', -1);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Try again later.Something went wrong'], 500);
        }
    }

    // User Logout
    function UserLogout()
    {
        Session::forget('user_name');
        Session::forget('user_role');
        return redirect('/')->cookie('token', '', -1);
    }
}
