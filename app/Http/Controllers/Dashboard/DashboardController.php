<?php

namespace App\Http\Controllers\Dashboard;

use App\Common\BaseResponse\ResponseBuilder;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Stock;

class DashboardController extends Controller
{
  public function index()
  {
    $data = [
      'product_count' => Product::count(),
      'category_count' => Category::count(),
      'purchase_count' => Purchase::count(),

    ];

    return response()->json(ResponseBuilder::build(
      200,
      true,
      'Ok',
      $data
    ));
  }
}