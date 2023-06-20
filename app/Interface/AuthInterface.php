<?php

namespace App\Interface;

interface AuthInterface {
    public function login($validator);
    public function register($validator);
    public function logout();
    public function refresh();
    public function userProfile();
    public function verfyEmail($email);
    public function sendEmail($user);

}
