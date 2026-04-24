<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class AdminController extends Controller
{

    public function dashboard()
    {
        return view('admin.dashboard.main');
    }

    //create new admin account
    public function createAdminPage()
    {
        return view('admin.account.newAdmin');
    }

    //create new admin account
    public function createAdmin(Request $request){
        $this->checkAccountValidation($request);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        Alert::success('Success Title', 'New Admin Account Created Successfully');

        return back();

    }

    //admin list
    public function adminList() {
        $admin = User::select('id','name','nickname','email','address','phone','role','created_at','provider','profile')
                    ->whereIn('role', ['admin','superadmin'])
                    ->when(request('searchKey'), function($query){
                        $query->whereAny(['name','email','phone','address','role','provider'],'like','%'.request('searchKey').'%');
                    })
                    ->paginate(5);
        return view('admin.account.adminList', compact('admin'));
    }

    //admin delete
    public function adminDelete($id){
        User::where('id', $id)->delete();
        return back();
    }

    //user list
    public function userList() {

        $user = User::select('id','name','nickname','email','address','phone','role','created_at','provider','profile')
                    ->where('role','user')
                    ->when(request('searchKey'), function($query){
                        $query->whereAny(['name','email','phone','address','role','provider'],'like','%'.request('searchKey').'%');
                    })
                    ->paginate(5);

        return view('admin.account.userList', compact('user'));
    }

    //user delete
    public function userDelete($id){
        User::where('id', $id)->delete();
        return back();
    }

    //check account validation
    private function checkAccountValidation($request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:6|max:12',
            'confirmPassword' => 'required|min:6|max:12|same:password'
        ]);
    }
}
