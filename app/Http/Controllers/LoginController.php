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
use App\Models\UserAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        if(Auth::check())
            return redirect('/');
        return view('login');
    }

    public function validateLogin(Request  $req)
    {
        $remember = ($req->remember) ? true: false;
        if(Auth::attempt(['username' => $req->username, 'password' => $req->password], $remember )){
            $login = UserAccess::where('user_id',Auth::id())
                        ->exists();
            if(!$login){
                Auth::logout();
                return redirect()->back()->with('denied',true);
            }
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
