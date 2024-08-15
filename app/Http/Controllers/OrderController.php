<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    function getView(){
        $order_project = OrderModel::all();




        return view('auth.order.order');
    }
}
