<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

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


}
