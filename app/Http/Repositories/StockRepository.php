<?php

namespace App\Http\Repositories;

use App\Models\Stock;

class StockRepository
{
  public function list(int $size)
  {
    return Stock::withTrashed()->with('hasProduct', function($q) {
      $q->withTrashed();
    })->paginate($size);
  }

  public function detail(string $id)
  {
    return Stock::withTrashed()->where('id', $id)->with('hasProduct', function($q) {
      $q->withTrashed();
    })->firstOrFail();
  }

  public function update(Stock $data, array $newData)
  {
    $data->qty = $newData["qty"];
    $data->save();

    return $data;
  }
}