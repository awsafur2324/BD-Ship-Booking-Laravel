<?php

namespace App\Helper;

use App\Mail\varification_email;
use App\Mail\verification_forget_email;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class otp_sent
{
    public static function otpSent($email, $type)
    {
        $otp = rand(1000, 9999);
        $count = User::where('email', $email)->count();
        if ($count == 1) {
            try {
                if ($type == 'register_verification_otp') {
                    // OTP Email Address
                    Mail::to($email)->send(new varification_email($otp));
                } else if ($type == 'forgot_password_verification_otp') {
                    // OTP Email Address
                    Mail::to($email)->send(new verification_forget_email($otp));
                }

                // OTO Code Table Update
                User::where('email', '=', $email)->update(['otp' => $otp]);

                return true;
            } catch (\Exception $e) {
                return false;
            }
        } else {
            return false;
        }
    }
}
