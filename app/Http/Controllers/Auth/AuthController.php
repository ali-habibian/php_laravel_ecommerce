<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    /**
     * Redirect the user to the specified authentication provider.
     *
     * This function uses the Socialite package to handle the redirection logic for third-party authentication.
     * It selects the appropriate authentication driver based on the provided $provider parameter and performs the redirect.
     * This operation is typically used at the beginning of an OAuth flow, redirecting the user to a third-party service for authentication.
     *
     * @param string $provider The name of the authentication provider, e.g., 'google', 'facebook'.
     *                        This parameter determines which third-party service to use for authentication.
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToProvider(string $provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Handles the callback from a social provider.
     *
     * This method attempts to obtain user information from a specified social provider. If the user does not exist in the system, it creates a new user.
     * Then it logs in the user and redirects them to the home page.
     *
     * @param string $provider The name of the social provider, such as 'google' or 'facebook'.
     * @return RedirectResponse
     */
    public function handleProviderCallback(string $provider)
    {
        // Attempt to get the user information from the social provider.
        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (Exception $e) {
            // If an error occurs, redirect back to the login page.
            return redirect()->route('login');
        }

        // Check if the user already exists in the system based on their email.
        $user = User::where('email', $socialUser->getEmail())->first();

        // If user not found create new user
        if (!$user) {
            $user = User::create([
                'name' => $socialUser->getName(),
                'email' => $socialUser->getEmail(),
                'password' => Hash::make($socialUser->getId()),
                'provider_name' => $provider,
                'avatar' => $socialUser->getAvatar(),
                'email_verified_at' => Carbon::now()
            ]);
        }

        // Login the user and remember them.
        auth()->login($user, remember: true);

        // Redirect user to the index page with a success message.
        return redirect()->route('home.index')->with('success', 'شما با موفقیت وارد شدید');
    }
}
