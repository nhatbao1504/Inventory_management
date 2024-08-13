<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    function getView(){
        return view('auth.order.order');
    }
}
