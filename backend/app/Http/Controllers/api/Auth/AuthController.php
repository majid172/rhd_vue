<?php

namespace App\Http\Controllers\api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login()
    {
        return 'login';
    }
    public function loginStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|min:1|max:100',
            'password' => 'required|min:1|max:30',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'Validation failed');
        }
//        $user = User::where('username', $request['username'])->first();
        $credentials = $request->only('username','password');

        if (Auth::attempt($credentials))
        {
            $user = Auth::user();
            $data['name'] = $user->name;
            $token = $user->createToken('accessToken')->accessToken;

            if ($user->status == 1) {
                if (Auth::attempt(['username' => $request['username'], 'password' => $request['password']])) {
                    if (Auth::user()->roles === 'admin') {
                        return redirect()->route('report.chart.report')->with('success', 'Successfully logged in');
                    } else if (Auth::user()->roles === 'administrator') {
                        return redirect()->route('report.chart.report')->with('success', 'Successfully logged in');
                    } else if (Auth::user()->roles === 'manager') {
                        return redirect()->route('report.chart.report')->with('success', 'Successfully logged in');
                    }
                    else if (Auth::user()->roles === 'bank') {
                        return redirect()->route('bank.dashboard.user')->with('success', 'Successfully logged in');
                    }  else {
                        return redirect()->route('login.index')->with('danger', 'Logged in failed');
                    }
                } else {
                    return redirect()->back()->with('danger', 'User and password do not match. Please provide valid credentials.');
                }
            } else {
                return redirect()->back()->with('danger', 'Sorry, your account is currently disabled. Contact support for assistance.');
            }


        }

    }
}
