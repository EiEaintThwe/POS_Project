<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function dashboard(){
        return view('admin.dashboard.main');
   }

   //create new admin account
   public function createAdminPage(){

   }

   //admin list
   public function adminList(){

   }

   //user list
   public function userList(){

   }
}

