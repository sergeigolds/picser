<?php

namespace App\Http\Controllers;


use App\Models\ApiToken;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user_id = Auth::id();
            $tokens = ApiToken::where('user_id', $user_id)->get();

            return view('home', [
                'user_tokens' => $tokens,
            ]);
        }

        return view('home');
    }
}
