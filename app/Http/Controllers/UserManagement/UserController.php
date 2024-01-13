<?php

namespace App\Http\Controllers\UserManagement;

use App\Common\BaseResponse\ResponseBuilder;
use App\Http\Controllers\Controller;
use App\Http\Repositories\UserRepository;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Responses\UserResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
  protected $userRepo;

  public function __construct(UserRepository $userRepo)
  {
    $this->userRepo = $userRepo;
  }

  public function create(UserRequest $req)
  {
    $payload = [
      'name' => $req->name,
      'email' => $req->email,
      'password' => Hash::make($req->password),
      'role_id' => $req->role_id,
    ];

    $data = $this->userRepo->saveUser($payload);

    return response()->json(ResponseBuilder::build(
      201, 
      true, 
      'Data created successfully', 
      new UserResponse($data)
    ), 201);
  }

  public function index(Request $req)
  {
    $data = $this->userRepo->listUser($req->size ?? 10);

    return response()->json(ResponseBuilder::build(
      200,
      true,
      'Ok',
      UserResponse::collection($data),
      true
    ), 200);
  }

  public function show(Request $req)
  {
    $data = $this->userRepo->detailUser($req->id);

    return response()->json(ResponseBuilder::build(
      201, 
      true, 
      'Ok', 
      new UserResponse($data)
    ), 201);
  }

  public function update(Request $req, UserUpdateRequest $newData)
  {
    $payload = [
      'name' => $newData->name,
      'role_id' => $newData->role_id,
    ];

    $tmp = $this->userRepo->detailUser($req->id);

    $data = $this->userRepo->updateUser($tmp, $payload);

    return response()->json(ResponseBuilder::build(
      201,
      true,
      'Data updated successfully',
      new UserResponse($data)
    ), 201);    
  }

  public function delete(Request $req)
  {
    $this->userRepo->delete($req->id);

    return response()->json(ResponseBuilder::build(
      200,
      true,
      'Data deleted successfully'
    ), 200);
  }
}
