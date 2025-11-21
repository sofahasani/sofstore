<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Exception;

class SocialAuthController extends Controller
{
    /**
     * Redirect to social provider (Mock untuk testing tanpa Socialite)
     */
    public function redirectToProvider($provider)
    {
        // Validate provider
        if (!in_array($provider, ['google', 'facebook', 'linkedin'])) {
            return redirect()->route('login')->with('error', 'Invalid social provider');
        }

        // Untuk testing, langsung redirect ke callback dengan mock data
        // Nanti setelah install Socialite, ganti dengan: return Socialite::driver($provider)->redirect();
        
        // Mock URL untuk simulasi (sementara untuk testing)
        return redirect()->route('social.callback.mock', ['provider' => $provider]);
    }

    /**
     * Handle mock callback untuk testing (hapus setelah install Socialite)
     */
    public function handleMockCallback($provider)
    {
        // Mock user data untuk testing
        $mockUsers = [
            'google' => [
                'id' => 'google_123456',
                'email' => 'user@gmail.com',
                'name' => 'Google User',
                'avatar' => 'https://ui-avatars.com/api/?name=Google+User&background=4285F4&color=fff',
            ],
            'facebook' => [
                'id' => 'facebook_789012',
                'email' => 'user@facebook.com',
                'name' => 'Facebook User',
                'avatar' => 'https://ui-avatars.com/api/?name=Facebook+User&background=1877F2&color=fff',
            ],
            'linkedin' => [
                'id' => 'linkedin_345678',
                'email' => 'user@linkedin.com',
                'name' => 'LinkedIn User',
                'avatar' => 'https://ui-avatars.com/api/?name=LinkedIn+User&background=0A66C2&color=fff',
            ],
        ];

        $socialUser = (object) $mockUsers[$provider];

        try {
            // Check if user exists
            $user = User::where('email', $socialUser->email)->first();

            if ($user) {
                // Update user's social info if needed
                $this->updateUserSocialInfo($user, $provider, $socialUser);
            } else {
                // Create new user
                $user = $this->createUserFromSocial($provider, $socialUser);
            }

            // Log the user in
            Auth::login($user, true);

            return redirect()->intended('/dashboard')->with('success', 'Successfully logged in with ' . ucfirst($provider) . ' (Mock Mode)');

        } catch (Exception $e) {
            return redirect()->route('login')->with('error', 'Authentication failed: ' . $e->getMessage());
        }
    }

    /**
     * Handle callback from social provider (akan digunakan setelah install Socialite)
     */
    public function handleProviderCallback($provider)
    {
        // Validate provider
        if (!in_array($provider, ['google', 'facebook', 'linkedin'])) {
            return redirect()->route('login')->with('error', 'Invalid social provider');
        }

        try {
            // Uncomment setelah install Socialite:
            // $socialUser = Socialite::driver($provider)->user();
            
            // Sementara redirect ke mock
            return $this->handleMockCallback($provider);

        } catch (Exception $e) {
            return redirect()->route('login')->with('error', 'Authentication failed. Please try again.');
        }
    }

    /**
     * Create a new user from social provider data
     */
    private function createUserFromSocial($provider, $socialUser)
    {
        $user = User::create([
            'name' => $socialUser->name ?? 'User',
            'email' => $socialUser->email,
            'password' => Hash::make(uniqid()), // Random password for social login users
            'email_verified_at' => now(), // Auto-verify email for social login
            'provider' => $provider,
            'provider_id' => $socialUser->id,
            'avatar' => $socialUser->avatar ?? null,
        ]);

        return $user;
    }

    /**
     * Update existing user's social info
     */
    private function updateUserSocialInfo($user, $provider, $socialUser)
    {
        $updateData = [
            'provider' => $provider,
            'provider_id' => $socialUser->id,
        ];

        // Update avatar if user doesn't have one
        if (!$user->avatar && isset($socialUser->avatar)) {
            $updateData['avatar'] = $socialUser->avatar;
        }

        // Auto-verify email if not verified
        if (!$user->email_verified_at) {
            $updateData['email_verified_at'] = now();
        }

        $user->update($updateData);

        return $user;
    }
}
