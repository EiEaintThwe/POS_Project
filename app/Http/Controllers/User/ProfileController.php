<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class ProfileController extends Controller
{
    //edit profile
    public function editProfile()
    {

        return view('user.profile.edit');
    }

    //update profile
    public function updateProfile(Request $request)
    {
        $this->checkProfileValidation($request);

        $data = $this->getProfileData($request);

        if ($request->hasFile('image')) {
            if (Auth::user()->profile != null) {
                if (file_exists(public_path() . '/profile/' . Auth::user()->profile)) {
                    unlink(public_path() . '/profile/' . Auth::user()->profile);
                }
            }

            $fileName = uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path() . '/profile/', $fileName);

            $data['profile'] = $fileName;
        } else {
            $data['profile'] = Auth::user()->profile;
        }


        User::where('id', Auth::user()->id)->update($data);
        Alert::success('Success Title', 'Profile Updated Successfully');
        return back();
    }

    //change password page
    public function changePasswordPage()
    {
        return view('user.profile.changePassword');
    }

    //change password
    public function changePassword(Request $request)
    {

        $userRegisterPassword = Auth::user()->password;

        if ($userRegisterPassword != null) {
            if (Hash::check($request->oldPassword, $userRegisterPassword)) {
                $this->checkPasswordValidation($request);

                User::where('id', Auth::user()->id)->update([
                    'password' => Hash::make($request->newPassword)
                ]);

                Alert::success('Success Title', 'Password Changed Successfully');

                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect('/');

            } else {
                Alert::error('Process fail...', 'Old password does not match our records. Try again!');
                return back();
            }
        } else {
            User::where('id', Auth::user()->id)->update([
                'password' => Hash::make($request->newPassword)
            ]);

             Alert::success('Success Title', 'Password Created Successfully');
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/');
        }
    }

    //get profile data
    private function getProfileData($request)
    {
        return [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address
        ];
    }

    //check password validation
    private function checkPasswordValidation($request)
    {
        $request->validate([
            'oldPassword' => 'required',
            'newPassword' => 'required|min:6|max:12',
            'confirmPassword' => 'required|min:6|max:12|same:newPassword'
        ]);
    }

    //check profile validation
    private function checkProfileValidation($request)
    {
        $request->validate([
            'name' => 'required|min:2|max:30',
            'email' => 'required',
            'phone' => 'required|max:20',
            'address' => 'max:200',
            'image' => 'file|mimes:jpg,jpeg,png,webp,svg,gif'
        ]);
    }
}
