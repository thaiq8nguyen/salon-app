<?php

namespace App\Http\Controllers;

use Validator;
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

    public function register(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'firstName' => 'required|string|max:20',
            'lastName' => 'required|string|max:20',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6|max:12'
        ]);

        if ($validation->fails()) {
            return $this->sendError('Invalid request parameters', $validation->errors(), 401);
        }

        $user = $this->user->register($request->all());

        return $this->sendResponse(['name' => 'user', 'value' => $user], 'User has been created');
    }

    public function getUsers(Request $request)
    {
        $users = '';
        if ($request->has('filter')) {
            if ($request->input('filter') == 'unapproved') {
                $users = $this->user->getUnApprovedUsers();
            }
        }

        return $this->sendResponse(['name' => 'users', 'value' => $users ], 'Users retrieved successfully');
    }

    public function approveUser($userID)
    {
        $user = $this->user->approveUser($userID);

        return $this->sendResponse(['name' => 'users', 'value' => $user], 'The user has been approved');
    }
}
