<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $r)
    {
        // هنا تبني المنطق الفعلي للمصادقة عبر API…
        // لنفترض أنّ المستخدم يُدخل توكن الـ API مباشرة:
        $r->validate(['api_token' => 'required|string']);
        Session::put('api_token', $r->input('api_token'));
        return redirect()->intended(route('profile.show'));
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $r)
    {
        // لو عندك API تسجيل، نفّذه هنا ثم خزّن التوكن
        // للآن نجعلها dummy:
        return redirect()->route('login');
    }
}
