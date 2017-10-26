<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $owner = new Role();
//        $owner->name         = 'user';
//        $owner->display_name = 'App user'; // optional
//        $owner->description  = 'User is the user of the app'; // optional
//        $owner->save();

//        $admin = new Role();
//        $admin->name         = 'admin';
//        $admin->display_name = 'User Administrator'; // optional
//        $admin->description  = 'User is allowed to manage and edit other users'; // optional
//        $admin->save();

//        $user = User::where('id', '=', 2)->first();
//        $role = Role::where('id', '=', 3)->first();
//
//        // role attach alias
//        $user->attachRole($role);

        return view('home');
    }
}
