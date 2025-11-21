<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $response = [
            'success' => true,
            'message' => 'Profile updated successfully'
        ];

        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('profile_images'), $imageName);
            $response['profile_image'] = '/profile_images/' . $imageName;
        }

        return response()->json($response);
    }
}