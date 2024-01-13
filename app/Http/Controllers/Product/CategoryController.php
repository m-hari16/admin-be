<?php

namespace App\Http\Controllers\Product;

use App\Common\BaseResponse\ResponseBuilder;
use App\Http\Controllers\Controller;
use App\Http\Repositories\CategoryRepository;
use App\Http\Requests\CategoryRequest;
use App\Http\Responses\CategoryResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
  protected $categoryRepo;

  public function __construct(CategoryRepository $categoryRepo)
  {
    $this->categoryRepo = $categoryRepo;
  }

  public function create(CategoryRequest $req)
  {
    $payload = [
      'name' => $req->name
    ];

    $data = $this->categoryRepo->saveCategory($payload);

    return response()->json(ResponseBuilder::build(
      201, 
      true, 
      'Data created successfully', 
      new CategoryResponse($data)
    ), 201);
  }

  public function index(Request $req)
  {
    $data = $this->categoryRepo->listCategory($req->size ?? 10);

    return response()->json(ResponseBuilder::build(
      200,
      true,
      'Ok',
      CategoryResponse::collection($data),
      true
    ), 200);
  }

  public function show(Request $req)
  {
    $data = $this->categoryRepo->detailCategory($req->id);

    return response()->json(ResponseBuilder::build(
      201, 
      true, 
      'Ok', 
      new CategoryResponse($data)
    ), 201);
  }

  public function update(Request $req, CategoryRequest $newData)
  {
    $payload = [
      'name' => $newData->name
    ];

    $tmp = $this->categoryRepo->detailCategory($req->id);

    $data = $this->categoryRepo->updateCategory($tmp, $payload);

    return response()->json(ResponseBuilder::build(
      201,
      true,
      'Data updated successfully',
      new CategoryResponse($data)
    ), 201);    
  }

  public function delete(Request $req)
  {
    $this->categoryRepo->delete($req->id);

    return response()->json(ResponseBuilder::build(
      200,
      true,
      'Data deleted successfully'
    ), 200);
  }
}
