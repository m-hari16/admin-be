<?php

namespace App\Http\Controllers\Product;

use App\Common\BaseResponse\ResponseBuilder;
use App\Http\Controllers\Controller;
use App\Http\Repositories\ProductRepository;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Responses\ProductResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
  protected $repo;

  public function __construct(ProductRepository $repo)
  {
    $this->repo = $repo;
  }

  public function create(ProductRequest $req)
  {
    $payload = [
      'code' => $req->code,
      'name' => $req->name,
      'specification' => $req->specification,
      'uom' => $req->uom,
      'isActive' => $req->isActive,
      'category_id' => $req->category_id,
    ];

    $data = $this->repo->save($payload);

    return response()->json(ResponseBuilder::build(
      201, 
      true, 
      'Data created successfully', 
      new ProductResponse($data)
    ), 201);
  }

  public function index(Request $req)
  {
    $data = $this->repo->list($req->size ?? 10);

    return response()->json(ResponseBuilder::build(
      200,
      true,
      'Ok',
      ProductResponse::collection($data),
      true
    ), 200);
  }

  public function show(Request $req)
  {
    $data = $this->repo->detail($req->id);

    return response()->json(ResponseBuilder::build(
      201, 
      true, 
      'Ok', 
      new ProductResponse($data)
    ), 201);
  }

  public function update(Request $req, ProductUpdateRequest $newData)
  {
    $payload = [
      'name' => $newData->name,
      'specification' => isset($newData->specification) ? json_encode($newData->specification) : json_encode([]),
      'uom' => $newData->uom,
      'isActive' => $newData->isActive,
      'category_id' => $newData->category_id,
    ];

    $tmp = $this->repo->detail($req->id);

    $data = $this->repo->update($tmp, $payload);

    return response()->json(ResponseBuilder::build(
      201,
      true,
      'Data updated successfully',
      new ProductResponse($data)
    ), 201);    
  }

  public function delete(Request $req)
  {
    $this->repo->delete($req->id);

    return response()->json(ResponseBuilder::build(
      200,
      true,
      'Data deleted successfully'
    ), 200);
  }
}
