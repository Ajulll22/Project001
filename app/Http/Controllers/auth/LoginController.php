<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index()
    {
        return view('pages.login');
    }

    public function login(Request $request)
    {
        $user = User::where( "email", $request->input("email") )->first();
        if (!$user) {
            return [
                "status"=> "error",
                "title" => "Gagal",
                "message"=> "Email dan Password Tidak Sesuai."
            ];
        } else if (!Hash::check($request->password, $user->password)) {
            return [
                "status"=> "error",
                "title" => "Gagal",
                "message"=> "Email dan Password Tidak Sesuai."
            ];
        }

        Auth::login($user);
        $request->session()->regenerate();
        return [
            "status"=> "success",
            "title" => "Berhasil",
            "message"=> "Login Berhasil."
        ];
    }

    public function logout()
    {
        Auth::logout();
        return redirect(route('sign_in'));
    }
}
