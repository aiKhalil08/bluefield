<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function show_login_form(): Response {
        $view = 'adminlogin';#request()->expectsJson() ? 'json.admin.login' : 'nojson.admin.login';
        return response()->view($view);
    }

    public function login(): JsonResponse {
        // $view = 'adminlogin';#request()->expectsJson() ? 'json.admin.login' : 'nojson.admin.login';
        $validated = request()->validate([
            'username' => ['required', 'max:20'],
            'password' => ['required',],
            'role' => ['required'] ,
        ]);
        // return response()->view($view);
        if (Auth::guard('staff')->attempt($validated)) {
            request()->session()->regenerate();
            return response()->json(['status'=>'authenticated']);
        }
        return response()->json(['status'=>'unauthenticated']);
    }

    public function logout($type) : JsonResponse {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return response()->json(['status'=>'success']);
    }
}
