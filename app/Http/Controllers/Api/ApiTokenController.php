<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ApiToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiTokenController extends Controller
{
    public function create(Request $request)
    {

        $request->validate([
            'token_name' => 'required',
            'token_domain' => 'required',
        ]);

        $user = Auth::user();
        $token = $user->createToken($request->token_name);
        $token_key = explode('|', $token->plainTextToken)[1];

        $data = [
            'token_id' => $token->accessToken->getKey(),
            'user_id' => $user->id,
            'token_name' => $request->token_name,
            'token_key' => $token_key,
            'token_domain' => $request->token_domain,
        ];

        ApiToken::create($data);

        return redirect(route('home'))->with('success', 'Token successfully created.');
    }

    public function delete($id)
    {
        $user = Auth::user();
        $user->tokens()->where('id', $id)->delete();
        ApiToken::where('token_id', $id)->delete();

        return redirect(route('home'));
    }
}
