<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Events\UserRegistered;
use App\Http\Controllers\Controller;

class RegenerateOtpController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'email' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        $user->generateCodeOtp();
        
        $data['user'] = $user;
        
        event(new UserRegistered($user, 'regenerate'));

        return response()->json([
            'response_code' => '00',
            'response_message' => 'kode OTP berhasil di generate, silahkan cek email untuk melihat kode OTP',
            'data' => $data
        ]);
    }
}
