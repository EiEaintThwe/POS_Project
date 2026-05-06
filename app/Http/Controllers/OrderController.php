<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //direct to order list
    public function orderList(){
        $orderList = Order::selectRaw('DISTINCT ON(order_code) orders.id,orders.order_code,orders.status,orders.created_at,users.name')
                        ->leftJoin('users','orders.user_id','users.id')
                        ->orderBy('orders.order_code')
                        ->orderBy('orders.created_at','desc')
                        ->get();

        return view('admin.order.list',compact('orderList'));
    }

    //order details
    public function orderDetails(){
        return view('admin.order.details');

    }
}
