<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ProfileController extends Controller
{
    public function show()
    {
        $data['profile'] = auth()->user();

        return response()->json([
            'response_code' => '00',
            'response_message' => 'Profile berhasil ditampilkan',
            'data' => $data
        ], 200);
    }

    public function update(Request $request)
    {
        $validate = $request->validate([
            'photo_profile' => 'file|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $user = auth()->user();
        $now = Carbon::now();
        if ($validate) {
            $image = $request->file('photo_profile');
            $image_name = Carbon::now()->format('Y-m-d') . '-' . $user->username . '.png';
            $image_folder = '/photos/users/photo-profile/';
            $image_location = $image_folder . $image_name;

            try {
                $image->move(public_path($image_folder), $image_name);

                $user->update([
                    'photo_profile' => $image_location
                ]);
            } catch (\Exception $exception) {
                return response()->json([
                    'response_code' => '01',
                    'response_message' => 'gagal',
                    'data' => $user
                ], 200);
            }
        }

        $user->update([
            'name' => $request->name,
        ]);

        $data['profile'] = $user;

        return response()->json([
            'response_code' => '00',
            'response_message' => 'berhasil di update',
            'data' => $data
        ], 200);
    }
}
