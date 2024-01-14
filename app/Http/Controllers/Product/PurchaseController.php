<?php

namespace App\Http\Controllers\Product;

use App\Common\BaseResponse\ResponseBuilder;
use App\Http\Controllers\Controller;
use App\Http\Repositories\PurchaseRepository;
use App\Http\Requests\PurchaseRequest;
use App\Http\Responses\PurchaseResponse;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
  protected $repo;

  public function __construct(PurchaseRepository $repo)
  {
    $this->repo = $repo;
  }

  public function create(PurchaseRequest $req)
  {
    $payload = [
      'code' => uniqid("INV-"),
      'qty' => $req->qty,
      'price' => $req->price,
      'product_id' => $req->product_id,
    ];

    $data = $this->repo->save($payload);

    return response()->json(ResponseBuilder::build(
      201, 
      true, 
      'Data created successfully', 
      new PurchaseResponse($data)
    ), 201);
  }

  public function index(Request $req)
  {
    $data = $this->repo->list($req->size ?? 10);

    return response()->json(ResponseBuilder::build(
      200,
      true,
      'Ok',
      PurchaseResponse::collection($data),
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
      new PurchaseResponse($data)
    ), 201);
  }

  public function update(Request $req, PurchaseRequest $newData)
  {
    $payload = [
      'qty' => $newData->qty,
      'price' => $newData->price,
      'product_id' => $newData->product_id,
    ];

    $tmp = $this->repo->detail($req->id);

    $data = $this->repo->update($tmp, $payload);

    return response()->json(ResponseBuilder::build(
      201,
      true,
      'Data updated successfully',
      new PurchaseResponse($data)
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
