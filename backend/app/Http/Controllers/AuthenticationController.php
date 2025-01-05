<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SignInRequest;
use App\Http\Requests\SignUpRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    public function signIn(SignInRequest $request)
    {
        $validated = $request->validated();

        $user = User::where("email", $validated["email"])->first();

        if(!$user || !Hash::check($validated["password"], $user->password))
        {
            return response()->noContent(400);
        }

        $token = $user->createToken("access_token")->plainTextToken;

        return response()->json([
            "access_token" => $token,
            "token_type" => "Bearer",
            "user" => $user
        ]);
    }

    public function signUp(SignUpRequest $request, User $user)
    {
        $validated = $request->validated();

        $user->name = $validated["name"];
        $user->email = $validated["email"];
        $user->password = $validated["password"];

        $user->save();
        $token = $user->createToken("access_token")->plainTextToken;

        return response()->json([
            "access_token" => $token,
            "token_type" => "Bearer",
            "user" => $user
        ]);
    }
}
