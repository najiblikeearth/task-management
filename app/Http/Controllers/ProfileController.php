<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;

class ProfileController extends Controller
{

    public function updateProfile(Request $request)
    {
        $request->validate([
            'address' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:15',
            'birthdate' => 'nullable|date_format:Y-m-d',
        ]);

        $user = auth()->user();

        $userData = Profile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'address' => $request->input('address'),
                'phone_number' => $request->input('phone_number'),
                'birthdate' => $request->input('birthdate')
            ]
        );

        return response([
            "message" => "Profil berhasil dibuat/diupdate"
        ], 201);
    }
}
