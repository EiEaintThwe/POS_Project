<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Contact;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Payment_history;
use App\Models\PaymentHistory;
use App\Models\Product;
use App\Models\Rating;
use function Laravel\Prompts\number;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    //direct user homepage
    public function home(){
        $products = Product::select('products.id','products.name','products.description','products.price','products.image','products.category_id','categories.name as category_name')
                        ->leftJoin('categories','products.category_id','categories.id')
                        ->when(request('categoryId'),function($query){
                            $query->where('products.category_id',request('categoryId'));
                        })
                        ->when(request('searchKey'),function($query){
                            $query->where('products.name','like','%'.request('searchKey').'%');
                        })
                        ->when(request('minPrice') != null && request('maxPrice') != null , function($query){
                            $query->whereBetween('products.price',[request('minPrice'),request('maxPrice')]);
                        })
                        ->when(request('minPrice') != null && request('maxPrice') == null , function($query){
                            $query->where('products.price','>=',request('minPrice'));
                        })
                        ->when(request('minPrice') == null && request('maxPrice') != null , function($query){
                            $query->where('products.price','<=',request('maxPrice'));
                        })
                        ->when(request('sortingType'), function($query){
                            $sortingRules = explode(",",request('sortingType'));
                            $query->orderBy('products.'.$sortingRules[0], $sortingRules[1]);
                        })
                        ->get();

        $categories = Category::select('id','name')->get();
        return view('user.home', compact('products','categories'));
    }

    //product details page
    public function productDetails($id){
        $product = Product::select('products.id','products.name','products.stock','products.description','products.price','products.image','products.category_id','categories.name as category_name')
                        ->leftJoin('categories','products.category_id','categories.id')
                        ->where('products.id',$id)
                        ->first();

        // $productList = Product::select('products.id','products.name','products.description','products.price','products.image','products.category_id','categories.name as category_name')
        //                 ->leftJoin('categories','products.category_id','categories.id')
        //                 ->get();

        $comments = Comment::select('comments.id as comment_id','comments.message','comments.created_at','users.id as user_id','users.profile','users.name')
                            ->where('comments.product_id',$id)
                            ->leftJoin('users','users.id','comments.user_id')
                            ->orderBy('comments.created_at','desc')
                            ->get();

        $stars = number_format(Rating::where('product_id',$id)->avg('count'));

        $userRating = number_format(Rating::where('product_id',$id)->where('user_id',Auth::user()->id)->value('count'));
        return view('user.details',compact('product','comments','stars','userRating'));
    }

    //comment
    public function comment(Request $request){
        Comment::create([
            'product_id' => $request->productId,
            'user_id' => Auth::user()->id,
            'message' => $request->comment
        ]);

        Alert::success('Success Title', 'Comment Created Successfully');

        return back();

    }

    //comment delete
    public function commentDelete($id){
        Comment::where('id',$id)->delete();

        return back();
    }

    //rating
    public function rating(Request $request){
        Rating::updateOrCreate([
            'user_id' => Auth::user()->id,
            'product_id' => $request->productId
        ],
        [
            'product_id' => $request->productId,
            'user_id' => Auth::user()->id,
            'count' => $request->productRating
        ]);

        Alert::success('Success Title', 'Rating Created Successfully');
        return back();

    }

    //direct cart page
    public function cart(){
        $cart = Cart::select('carts.id as cart_id','carts.qty','products.id as product_id','products.name','products.price','products.image')
                    ->leftJoin('products','carts.product_id','products.id')
                    ->where('carts.user_id',Auth::user()->id)
                    ->get();

        $priceTotal = 0;

        foreach($cart as $item){
            $priceTotal += $item->price * $item->qty;
        }

        return view('user.cart',compact('cart','priceTotal'));
    }

    //add to cart
    public function addToCart(Request $request){
        Cart::create([
            'user_id' => $request->userId,
            'product_id' => $request->productId,
            'qty' => $request->qty
        ]);

         Alert::success('Add to Cart Success!', 'Add to Cart Created Successfully');
        return back();

    }

    //cart delete
    public function cartDelete(Request $request){
        $cartId = $request['cartId'];

        Cart::where('id',$cartId)->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'cart delete success'
        ],200);

    }

    //temp storage
    public function tempStorage(Request $request){
        $orderTemp = [];

        foreach ($request->all() as $item) {
            array_push($orderTemp,[
                'product_id' => $item['product_id'],
                'user_id' => $item['user_id'],
                'count' => $item['count'],
                'status' => $item['status'],
                'order_code' => $item['order_code'],
                'finalAmt' => $item['totalAmt']
            ]);
        }

        Session::put('tempCart',$orderTemp);

        return response()->json([
            'status' => 'success',
            'message' => 'temp storage store successfully'
        ],200);

    }

    //direct to payment page
    public function paymentPage(){
        $paymentAcc = Payment::select('id','account_name','account_number','type')->orderBy('type','asc')->get();

        $orderTemp = Session::get('tempCart');
        return view('user.payment',compact('paymentAcc','orderTemp'));
    }

    //order product
    public function order(Request $request){
        $request->validate([
            'name' => 'required|min:2',
            'phone' => 'required',
            'address' => 'required|max:2000',
            'paymentType' => 'required',
            'payslipImage' => 'required|file|mimes:png,jpg,jpeg,svg,gif,webp'
        ]);

        $orderTemp = Session::get('tempCart');

        $paymentHistoryData=[
            'user_name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'payment_method' => $request->paymentType,
            'order_code' => $request->orderCode,
            'total_amt' => $request->totalAmount
        ];

        if($request->hasFile('payslipImage')){
            $fileName = uniqid().$request->file("payslipImage")->getClientOriginalName();
            $request->file("payslipImage")->move(public_path().'/payslipImage/',$fileName);
            $paymentHistoryData['payslip_image'] = $fileName;
        }

        PaymentHistory::create($paymentHistoryData);
       foreach($orderTemp as $item){
        Order::create([
             'product_id' => $item['product_id'],
                'user_id' => $item['user_id'],
                'count' => $item['count'],
                'status' => $item['status'],
                'order_code' => $item['order_code'],
        ]);

        Cart::where('user_id',$item['user_id'])->where('product_id',$item['product_id'])->delete();
       }

        Alert::success('Thank for your order!', 'Order Created Successfully');
        return to_route('user#orderList');

    }

    //direct to order list
    public function orderList(){
        $orderList = Order::selectRaw('DISTINCT ON (order_code) *')
                ->where('user_id', Auth::user()->id)
                ->orderBy('order_code')
                ->orderBy('created_at', 'desc')
                ->get();
        return view('user.orderList',compact('orderList'));
    }



    //contact page
    public function contactPage(){
        return view('user.contact');
    }

    //contact create page
    public function contactCreate(Request $request){
        $this->checkContactValidation($request);

        Contact::create([
            'user_id' => Auth::user()->id,
            'title' => $request->title,
            'message' => $request->message
        ]);

        Alert::success('Success Title', 'Contact Created Successfully');
        return back();

    }

    //check contact validation
    private function checkContactValidation($request){
        $request -> validate([
            'title' => 'required',
            'message' => 'required'
        ]);
    }


}
