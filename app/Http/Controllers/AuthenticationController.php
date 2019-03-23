<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bookkeeping\User\UserInterface;

class AuthenticationController extends BaseController
{
    protected $user;


    /**
     * AuthenticationController constructor.
     * @param UserInterface $user
     */
    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }

    public function login(Request $request)
    {
        $loggedIn = $this->user->login($request->all());

        if (!$loggedIn) {
            return $this->sendError('Incorrect email or password', [], 401);
        }

        return $this->sendResponse(['name' => 'user', 'value' => $loggedIn], 'The user is authenticated');
    }

    public function logout()
    {
        $loggedOut = $this->user->logout();

        if ($loggedOut) {
            return $this->sendResponse(['name' => 'user' , 'value' => $loggedOut], "You have logged out");
        } else {
            return $this->sendError("Logout Error", [], 400);
        }
    }
}
