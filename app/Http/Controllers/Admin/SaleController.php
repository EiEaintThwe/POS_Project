<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\PaymentHistory;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    //sale list
    public function saleList()
    {
        $saleList = Order::selectRaw('DISTINCT ON(order_code) orders.created_at,orders.order_code,orders.status,users.name as user_name')
            ->leftJoin('users', 'orders.user_id', 'users.id')
            ->where('orders.status',1)
            ->orderBy('orders.order_code')
            ->orderBy('orders.created_at', 'desc')
            ->get();

        return view('admin.sale.list', compact('saleList'));
    }

    //sale details
    public function saleDetails($orderCode)
    {
        $sale = Order::select('users.name as user_name', 'users.phone', 'users.address', 'products.id as product_id', 'products.name as product_name', 'products.image', 'products.price', 'products.stock', 'orders.id as order_id', 'orders.user_id', 'orders.order_code', 'orders.status', 'orders.count as order_count', 'orders.created_at')
            ->leftJoin('products', 'orders.product_id', 'products.id')
            ->leftJoin('users', 'orders.user_id', 'users.id')
            ->where('orders.order_code', $orderCode)
            ->get();

        $paymentHistory = PaymentHistory::select('payment_histories.*', 'payments.type as payment_type')
            ->leftJoin('payments', 'payments.id', 'payment_histories.payment_method')
            ->where('order_code', $orderCode)
            ->first();


        return view('admin.sale.details', compact('sale', 'paymentHistory'));
    }
}
