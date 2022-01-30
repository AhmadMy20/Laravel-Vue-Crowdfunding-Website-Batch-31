<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirectToProvider($provider)
    {

        $url = Socialite::driver($provider)->stateless()->redirect()->getTargetUrl();


        return response()->json([
            'url' => $url
        ]);
    }

    public function handleProvideCallback($provider)
    {
        try {
            $social_user = Socialite::driver($provider)->stateless()->user();

            if (!$social_user) {
                return response()->json([
                    'response' => '01',
                    'message' => 'Login Failed'
                ], 401);
            }

            $user = User::whereEmail($social_user->email)->first();

            if (!$user) {

                if ($provider == 'google') {
                    $photo_profile = $social_user->avatar;
                }
                $user = User::create([
                    'email' => $social_user->email,
                    'name' => $social_user->name,
                    'password' => bcrypt('secret'),
                    'email_verified_at' => Carbon::now(),
                    'photo_profile' => $photo_profile

                ]);
            }

            $data['user'] = $user;
            $data['token'] = auth()->login($user);

            return response()->json([
                'response' => '00',
                'message' => 'berhasil login',
                'data' => $data
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'response' => '01',
                'message' => 'gagal login',
            ], 401);
        }
    }
}
