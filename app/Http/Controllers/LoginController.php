<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use App\Models\Users;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Cache;
use Auth;
use Mail;
use Str;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // return form login
    public function index()
    {
        return view('user.login_user');
    }

    // form register
    public function register()
    {
        return view('user.register_user');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function register_create(RegisterRequest $request)
    {

        try {
            $token = strtoupper(Str::random(6));
            Cache::put('active-token', $token, 1440);
            $User = Users::create([
                'full_name' => $request->full_name,
                'email' => $request->email,
                'address' => $request->address,
                'password' => Hash::make($request->password),
                'active_token' => $token,
                'phone' => $request->phone

            ]);

            if ($User) {
                return redirect()->route('login')->with('login_success', 'Sign Up Success !');
            }

        } catch (\Throwable $th) {
            dd($th);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    //  login user
    public function loginUser(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        $user = Users::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return redirect()->back()->with('notification', 'Incorrect email or password');
    }
       
        if (Auth::attempt($credentials)) {
            $User = Auth::user();
            if ($User->status == 1) {
                return redirect()->route('user.index');
            } else {
                Mail::send('mails.Active-account.mail_active', compact('User'), function ($email) use ($User) {
                    $email->subject('Get Verification Code');
                    $email->to($User->email, $User->name);
                });
                return redirect()->back()->with('notification', 'Your account has not been activated!');
            }
        }

    }

    // logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('user.index');
    }


}