<?php

namespace App\Http\Controllers\UserManagement;

use App\Common\BaseResponse\ResponseBuilder;
use App\Http\Controllers\Controller;
use App\Http\Repositories\RoleRepository;
use App\Http\Requests\RoleRequest;
use App\Http\Responses\RoleResponse;
use Illuminate\Http\Request;

class RoleController extends Controller
{
  protected $roleRepo;

  public function __construct(RoleRepository $roleRepo)
  {
    $this->roleRepo = $roleRepo;
  }

  public function create(RoleRequest $req)
  {
    $payload = [
      'name' => $req->name
    ];

    $data = $this->roleRepo->saveRole($payload);

    return response()->json(ResponseBuilder::build(
      201, 
      true, 
      'Data created successfully', 
      new RoleResponse($data)
    ), 201);
  }

  public function index(Request $req)
  {
    $data = $this->roleRepo->listRole($req->size ?? 10);

    return response()->json(ResponseBuilder::build(
      200,
      true,
      'Ok',
      RoleResponse::collection($data),
      true
    ), 200);
  }

  public function show(Request $req)
  {
    $data = $this->roleRepo->detailRole($req->id);

    return response()->json(ResponseBuilder::build(
      201, 
      true, 
      'Ok', 
      new RoleResponse($data)
    ), 201);
  }

  public function update(Request $req, RoleRequest $newData)
  {
    $payload = [
      'name' => $newData->name
    ];

    $tmp = $this->roleRepo->detailRole($req->id);

    $data = $this->roleRepo->updateRole($tmp, $payload);

    return response()->json(ResponseBuilder::build(
      201,
      true,
      'Data updated successfully',
      new RoleResponse($data)
    ), 201);    
  }

  public function delete(Request $req)
  {
    $this->roleRepo->delete($req->id);

    return response()->json(ResponseBuilder::build(
      200,
      true,
      'Data deleted successfully'
    ), 200);
  }
}
