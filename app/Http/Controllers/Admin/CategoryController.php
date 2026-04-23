<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CategoryController extends Controller
{
    //direct category list
    public function list(){
        $categories = Category::orderBy('created_at','desc')->paginate(5);
        return view('admin.category.list', compact('categories'));
    }

    //create category
    public function create(Request $request){
        $this->checkValidation($request, 'create');

        Category::create([
            'name' => $request->categoryName
        ]);

        Alert::success('Success Title', 'Category Created Successfully');

        return back();

    }

    //edit category
    public function edit($id){
        $category = Category::where('id', $id)->first();
        return view('admin.category.edit', compact('category'));
    }

    //update category
    public function update(Request $request, $id){
        $request['id'] = $id;
        $this->checkValidation($request, 'update');

        Category::where('id', $id)->update([
            'name' => $request->categoryName
        ]);

        Alert::success('Success Title', 'Category Updated Successfully');

        return to_route('category#list');

    }

    //delete category
    public function delete($id){
        Category::where('id', $id)->delete();

        return back();
    }

    //check validation
    private function checkValidation($request, $action){

    if($action == 'create'){
        $request->validate([
            'categoryName' => 'required|min:2|max:30|unique:categories,name'
        ],[
            'categoryName.required' => 'Category Name is required'
        ]);
    }else{
        $request->validate([
            'categoryName' => 'required|min:2|max:30|unique:categories,name,'.$request->id
        ],[
            'categoryName.required' => 'Category Name is required'
        ]);
    }
}
}
