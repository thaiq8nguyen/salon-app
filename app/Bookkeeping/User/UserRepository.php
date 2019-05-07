<?php

namespace App\Bookkeeping\User;

use App\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UserRepository implements UserInterface
{
    public function login($credential)
    {
        if (Auth::attempt(['email' => $credential['email'], 'password' => $credential['password']])) {
            $user = Auth::user();
            $token = $user->createToken('access');

            $result = [
                'accessToken' => $token->accessToken,
                'expiration' => Carbon::parse($token->token->expires_at)->toDateTimeString(),
                'userFullName' => $user->name,
                'role' => $user->roles()->first()->name,
            ];

            return $result;
        }

        return false;
    }

    public function logout()
    {
        if (Auth::check()) {
            Auth::user()->token()->revoke();
            return true;
        }
        return false;
    }

    public function register($user)
    {
        $user = User::create([
            'name' => $user['firstName'].' '.$user['lastName'],
            'email' => $user['email'],
            'password' => bcrypt($user['password'])]);

        return $user;
    }

    public function getUnApprovedUsers()
    {
        $users = User::whereNull('approved_at')->get();

        return $users;
    }

    public function approveUser($userID)
    {
        $user = User::find($userID);

        $time = Carbon::now();

        $user->approved_at = $time->toDateTimeString();

        $user->save();

        return $user;
    }
}
