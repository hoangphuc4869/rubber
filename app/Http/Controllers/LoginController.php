<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;




class LoginController extends Controller
{
    public function loginForm(){
        return view("auth.login");
    }

    public function createuser(){

        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123'),
        ]);
    }

    public function handle_login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->remember)) {
           
            $user = Auth::user();

            if (in_array('customer', $user->roles->pluck('name')->toArray())) {
                return redirect()->route('tracibility');
            }
           
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('email', 'remember'));
    }

    // public function handle_login(Request $request)
    // {
    //     $credentials = $request->only('email', 'password');

    //     if (Auth::attempt($credentials)) {

    //         $user = Auth::user();
    //         if (empty($user->remember_token)) {
    //             $newToken = Str::random(60);

    //             $user->remember_token = $newToken;
    //             $user->save();  // Save the updated user to the database
    //         }

    //         return redirect()->intended('/');
    //     }

    //     return back()->withErrors([
    //         'email' => 'The provided credentials do not match our records.',
    //     ])->withInput($request->only('email'));
    // }


    public function logout(Request $request)
    {
        Auth::logout(); 

        return redirect('/login');
    }

    public function forgotIndex()
    {
        return view("auth.forgotPass");
    }

    public function forgot(Request $request)
    {
        Auth::logout(); 
        return redirect('/login');
    }


}