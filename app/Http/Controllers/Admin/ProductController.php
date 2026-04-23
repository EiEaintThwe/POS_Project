<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ProductController extends Controller
{
    //create page
    public function createPage(){
        $categories = Category::select('id', 'name')->get();
        return view('admin.product.create', compact('categories'));
    }

    //create product
    public function create(Request $request){
        $this->checkValidation($request, 'create');
        $data = $this->getData($request);

        if($request->hasFile('image')){
            $fileName = uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path().'/productImage/', $fileName);

            $data['image'] = $fileName;
        }

        Product::create($data);

        Alert::success('Success Title', 'Product Created Successfully');

        return back();

    }

    //get product data
    public function getData($request){
        return [
            'name' => $request->name,
            'category_id' => $request->categoryId,
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description
        ];

    }

    //product list
    public function list($action = 'default'){
        $products = Product::select('products.id','products.name','products.price','products.stock','products.image','products.category_id','categories.name as category_name')
                        ->leftJoin('categories', 'products.category_id', 'categories.id')
                        ->when($action == 'lowAmt', function($query){
                            $query->where('products.stock','<=',3);
                        })
                        ->when(request('searchKey'), function($query){
                            $query->whereAny(['products.name','products.price','categories.name'],'like','%'.request('searchKey').'%');
                        })
                        ->orderBy('products.created_at', 'desc')
                        ->get();
        return view('admin.product.list', compact('products'));
    }

    //product details
    public function details($id){
        $categories = Category::get();
        $product = Product::select('products.*','categories.name as category_name')
                        ->leftJoin('categories','products.category_id','categories.id')
                        ->where('products.id',$id)
                        ->first();

        return view('admin.product.details',compact('product','categories'));

    }


    //edit product
    public function edit($id){
        $categories = Category::get();
        $product = Product::where('id', $id)->first();
        return view('admin.product.edit', compact('product','categories'));
    }

    //update product
    public function update(Request $request){
        $this->checkValidation($request, 'update');
        $data = $this->getData($request);

        if($request->hasFile('image')){
            $oldImageName = $request->productImage;

            if(file_exists(public_path('productImage/'.$oldImageName))){
                unlink(public_path('productImage/'.$oldImageName));
            }

            if($request->hasFile('image')){
                $fileName = uniqid() . $request->file('image')->getClientOriginalName();
                $request->file('image')->move(public_path().'/productImage/', $fileName);
                $data['image'] = $fileName;
            }else{
                $data['image'] = $request->productImage;
            }
        }

        Product::where('id', $request->productId)->update($data);
        Alert::success('Success Title', 'Product Updated Successfully');
        return to_route('product#list');
    }


    //delete product
    public function delete($id){
        Product::where('id',$id)->delete();
        return back();
    }

    //check validation
    private function checkValidation($request, $action){
        $rules =[
            'name' => 'required|min:2|max:30',
            'categoryId' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric|max:999',
            'description' => 'required|max:2000'
        ];

        if($action == 'create'){
            $rules['name'] .= '|unique:products,name';
        }else{
            $rules['name'] .= '|unique:products,name,'.$request->productId;
        }

        $rules['image'] = $action == 'create' ? 'required|file|mimes:jpg,jpeg,png,webp,gif,svg' : 'file|mimes:jpg,jpeg,png,webp,gif,svg';

        $message = [];

        $request->validate($rules, $message);
    }
}
