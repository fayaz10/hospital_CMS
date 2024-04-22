<?php

namespace App\Http\Controllers\SystemAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    //

    public function index()
    {

        return view('system-admin.home');
    }
}
