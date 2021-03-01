<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\CategoryID;
use App\Models\CivilStatus;
use App\Models\Classification;
use App\Models\Confirmation;
use App\Models\EmploymentStatus;
use App\Models\PersonalInfo;
use App\Models\Profession;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function validateLogin(Request  $req)
    {
        $remember = ($req->remember) ? true: false;
        if(Auth::attempt(['username' => $req->username, 'password' => $req->password], $remember )){
            return redirect()->intended('/');
        }
        return redirect()->back()->with('error',true);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->intended('/login');
    }
}
