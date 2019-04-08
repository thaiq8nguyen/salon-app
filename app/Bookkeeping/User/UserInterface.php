<?php

namespace App\Bookkeeping\User;

interface UserInterface
{
    public function login($credential);

    public function logout();

    public function register($user);

    public function getUnApprovedUsers();

    public function approveUser($userID);

}
