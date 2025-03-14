<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Log;
class SocialLoginController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }


    public function callback($provider)
    {
        try {
            Log::info("OAuth callback started for provider: $provider");
            $socialUser = Socialite::driver($provider)->user();
    
            $user = User::updateOrCreate(
                ['provider_id' => $socialUser->getId(), 'provider' => $provider],
                [
                    'name' => $socialUser->getName(),
                    'email' => $socialUser->getEmail(),
                    'provider_token' => $socialUser->token,
                    'provider_refresh_token' => $socialUser->refreshToken,
                ]
            );
    
            // Use the web guard explicitly
            Auth::guard('web')->login($user, true);
            
            // Force immediate session save
            session()->save();
            request()->session()->regenerate();
    
            Log::info("Session ID after login: " . session()->getId());
            Log::info("Authenticated user: " . auth()->user()->id);
    
            return redirect()->intended(route('index'));
    
        } catch (\Exception $e) {
            Log::error("OAuth Error: " . $e->getMessage());
            return redirect()->route('login')->withErrors([
                'social_login' => 'Authentication failed. Please try again.'
            ]);
        }
    }
}