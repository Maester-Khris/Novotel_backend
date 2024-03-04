<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;
use Hash;

class AuthController extends Controller
{
    
    public function welcome(){
        return view("login");
    }
    
    public function login(Request $request){
        $credentials = $request->validate([
            'login' => ['required'],
            'password' => ['required'],
        ]);
        $user  = User::where("full_name",$request->login)->first();
       
        if($user){
            $ispass = Hash::check($request->password, $user->password);
            // dd($ispass);
            if($ispass){
                $request->session()->regenerate();
                Auth::login($user);
                return redirect()->intended('/dashboard');
            }else{
                return back()->withErrors([
                    'email' => 'The provided credentials do not match our records.',
                ]);
            }
        }else{
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);
        }
        // Auth::attempt($credentials)
    }

    public function logout(Request $request){
        // dont forget the last visite on user column
        $user = Auth::user();
        // dd($user);
        $user->last_visit = Carbon::today()->format('Y-m-d');
        $user->save();
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
