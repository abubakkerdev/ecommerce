<?php

namespace App\Http\Controllers;

use App\Models\Frontend\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class FacebookController extends Controller
{
    public function githubRedirect()
    {
        return Socialite::driver('github')->redirect();
    }

    public function githubCallback()
    {
        $user = Socialite::driver('github')->user();
        $user_info = Customer::where('email', $user->email)->exists();

        if ($user_info)
        {
            Auth::guard('customer')->attempt(['email' => $user->email, 'password' => 'Abu_18Years']);
        }
        else {
            Customer::insert([
                'name'          => $user->nickname,
                'email'         => $user->email,
                'password'      => bcrypt('Abu_18Years'),
                'created_at'    => Carbon::now()
            ]);

            Auth::guard('customer')->attempt(['email' => $user->email, 'password' => 'Abu_18Years']);

        }

        return redirect()->route('home.page');

    }


    public function googleRedirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function googleCallback()
    {
        $user = Socialite::driver('google')->user();
        $user_info = Customer::where('email', $user->email)->exists();

        if ($user_info)
        {
            Auth::guard('customer')->attempt(['email' => $user->email, 'password' => 'Abu_18Years']);
        }
        else {
            Customer::insert([
                'name'          => $user->name,
                'email'         => $user->email,
                'password'      => bcrypt('Abu_18Years'),
                'created_at'    => Carbon::now()
            ]);

            Auth::guard('customer')->attempt(['email' => $user->email, 'password' => 'Abu_18Years']);
        }

        return redirect()->route('home.page');

    }


    public function facebookRedirect()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function facebookCallback()
    {
        $user = Socialite::driver('facebook')->user();
        $user_info = Customer::where('email', $user->email)->exists();

        if ($user_info)
        {
            Auth::guard('customer')->attempt(['email' => $user->email, 'password' => 'Abu_18Years']);
        }
        else {
            Customer::insert([
                'name'          => $user->name,
                'email'         => $user->email,
                'password'      => bcrypt('Abu_18Years'),
                'created_at'    => Carbon::now()
            ]);

            Auth::guard('customer')->attempt(['email' => $user->email, 'password' => 'Abu_18Years']);
        }

        return redirect()->route('home.page');

    }

}
