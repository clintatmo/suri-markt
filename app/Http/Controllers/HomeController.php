<?php

namespace App\Http\Controllers;

use App\Role;
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
//        $owner->name         = 'owner';
//        $owner->display_name = 'Project Owner'; // optional
//        $owner->description  = 'User is the owner of a given project'; // optional
//        $owner->save();

//        $admin = new Role();
//        $admin->name         = 'admin';
//        $admin->display_name = 'User Administrator'; // optional
//        $admin->description  = 'User is allowed to manage and edit other users'; // optional
//        $admin->save();
        return view('home');
    }
}
