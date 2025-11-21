<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function show()
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login first');
        }
        
        // Load user with all required relationships
        $user = auth()->user()->load(['orders', 'wishlists', 'reviews', 'carts']);
        return view('profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        
        // Validate input
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
            'bio' => ['nullable', 'string', 'max:500'],
            'profile_picture' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);
        
        // Update user data
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        
        if (!empty($validated['phone'])) {
            $user->phone = $validated['phone'];
        }

        if (!empty($validated['address'])) {
            $user->address = $validated['address'];
        }
        
        if (!empty($validated['bio'])) {
            $user->bio = $validated['bio'];
        }
        
        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if exists
            if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
                Storage::disk('public')->delete($user->profile_picture);
            }
            
            // Store new profile picture
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $path;
        }
        
        $user->save();
        
        return response()->json(['success' => true, 'message' => 'Profile updated successfully!']);
    }
    
    public function updateUsername(Request $request)
    {
        $user = auth()->user();
        
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:50', 'alpha_dash', Rule::unique('users')->ignore($user->id)],
        ]);
        
        $user->username = $validated['username'];
        $user->save();
        
        return response()->json(['success' => true, 'message' => 'Username updated successfully!']);
    }

    public function updatePicture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        $user = auth()->user();
        
        // Delete old profile picture if exists
        if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
            Storage::disk('public')->delete($user->profile_picture);
        }
        
        // Store new profile picture
        $path = $request->file('profile_picture')->store('profile_pictures', 'public');
        
        $user->profile_picture = $path;
        $user->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Profile picture updated successfully!',
            'image_url' => Storage::url($path)
        ]);
    }
}