<?php

namespace App\Http\Controllers\Product;

use App\Common\BaseResponse\ResponseBuilder;
use App\Http\Controllers\Controller;
use App\Http\Repositories\StockRepository;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\StockRequest;
use App\Http\Responses\StockResponse;
use Illuminate\Http\Request;

class StockController extends Controller
{
  protected $repo;

  public function __construct(StockRepository $repo)
  {
    $this->repo = $repo;
  }

  public function index(Request $req)
  {
    $data = $this->repo->list($req->size ?? 10);

    return response()->json(ResponseBuilder::build(
      200,
      true,
      'Ok',
      StockResponse::collection($data),
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
      new StockResponse($data)
    ), 201);
  }

  public function update(Request $req, StockRequest $newData)
  {
    $payload = [
      'qty' => $newData->qty
    ];

    $tmp = $this->repo->detail($req->id);

    $data = $this->repo->update($tmp, $payload);

    return response()->json(ResponseBuilder::build(
      201,
      true,
      'Data updated successfully',
      new StockResponse($data)
    ), 201);    
  }
}
