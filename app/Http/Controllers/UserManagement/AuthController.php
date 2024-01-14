<?php

namespace App\Http\Controllers\UserManagement;

use App\Common\BaseResponse\ResponseBuilder;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Responses\UserResponse;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
  public function login(LoginRequest $req)
  {
    $userCred = [
      'email' => $req->email,
      'password' => $req->password
    ];

    if(!Auth::attempt($userCred)) {
      throw new AuthenticationException();
    }

    $token = Auth::user()->createToken('client1');

    $user = User::where('email', $userCred['email'])->with('hasRole')->firstOrFail();

    return response()->json(ResponseBuilder::build(
      201, 
      true, 
      'Login Successfully',
      [
        'user_data' => new UserResponse($user),
        'access_token' => $token->accessToken
      ]
    ), 201);
  }

  public function logout(Request $req)
  {
    Auth::user()->token()->revoke();

    return response()->json(ResponseBuilder::build(200, true, 'Logout successfully'), 200);
  }

}