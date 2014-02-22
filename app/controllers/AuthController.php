<?php

class AuthController extends BaseController
{

    public function status()
    {
        return Response::json(Auth::check());
    }

    public function register()
    {
        $password = Input::json('password');
        if ($password !== Input::json('password_confirmation')) {
            return Response::json(array('flash' => 'Invalid password confirmation'), 403);
        } else {
            $user = new User();
            $user->email = Input::json('email');
            $user->password = Hash::make($password);
            if($user->save()) {
                Auth::attempt(array('email' => $user->email, 'password' => $password));
                return Response::json(Auth::user());
            } else {
                return Response::json(array('flash' => 'Error'), 400);
            }
        }
    }

    public function login()
    {
        if (Auth::attempt(array('email' => Input::json('email'), 'password' => Input::json('password')))) {
            return Response::json(Auth::user());
        } else {
            return Response::json(array('flash' => 'Invalid username or password'), 403);
        }
    }

    public function logout()
    {
        Auth::logout();
        return Response::json(array('flash' => 'Logged Out!'));
    }

}
