<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        return response()->json($this->authService->login($data));
    }

    public function logout(Request $request)
    {
        return response()->json($this->authService->logout($request));
    }

    public function user(Request $request)
    {
        return response()->json($this->authService->getUser($request));
    }
}
