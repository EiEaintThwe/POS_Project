<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\PaymentHistory;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //direct to order list
    public function orderList(){
        $orderList = Order::selectRaw('DISTINCT ON(order_code) orders.id,orders.order_code,orders.status,orders.created_at,users.name,products.stock,products.id as product_id,orders.count')
                        ->leftJoin('users','orders.user_id','users.id')
                        ->leftJoin('products','orders.product_id','products.id')
                        ->orderBy('orders.order_code')
                        ->orderBy('orders.created_at','desc')
                        ->get();

        return view('admin.order.list',compact('orderList'));
    }



    //order details
    public function orderDetails($orderCode){
        $order = Order::select('users.name as user_name','users.phone','users.address','products.id as product_id','products.name as product_name','products.image','products.price','products.stock','orders.id as order_id','orders.user_id','orders.order_code','orders.status','orders.count as order_count','orders.created_at')
                        ->leftJoin('products','orders.product_id','products.id')
                        ->leftJoin('users','orders.user_id','users.id')
                        ->where('orders.order_code', $orderCode)
                        ->get();

        $paymentHistory = PaymentHistory::select('payment_histories.*','payments.type as payment_type')
                                        ->leftJoin('payments','payments.id','payment_histories.payment_method')
                                        ->where('order_code',$orderCode)
                                        ->first();

        $status = true;

        foreach ($order as $item) {
            if($item->order_count <= $item->stock){
                $status = true;
            }else{
                $status = false;
                break;
            }

        }
        return view('admin.order.details',compact('order','paymentHistory','status'));

    }

    //order reject
    public function orderReject(Request $request){
        Order::where('order_code',$request->orderCode)->update([
            'status' => 2
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Order reject successfully...'
        ],200);

    }

    //order confirm
   public function orderConfirm(Request $request){

    Order::where('order_code',$request->orderCode)
            ->update([
                'status' => 1
            ]);

    foreach($request->orderList as $item){

        Product::where('id',$item['productId'])
                ->decrement('stock',$item['count']);

    }

    return response()->json([
        'status' => 'success',
        'message' => 'Order confirm successfully...'
    ],200);

}

    //order status change
    public function orderStatusChange(Request $request){
        Order::where('order_code',$request->order_code)->update([
            'status' => $request->status
        ]);


         return response()->json([
            'status' => 'success',
            'message' => 'Order reject successfully...'
        ],200);
    }
}
