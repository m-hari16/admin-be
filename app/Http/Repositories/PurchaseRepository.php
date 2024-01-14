<?php

namespace App\Http\Repositories;

use App\Models\Product;
use App\Models\Purchase;

class PurchaseRepository
{
  public function save(array $data)
  {
    $product = Product::where('id', $data["product_id"])->firstOrFail();

    $purchase = $product->hasPurchase()->create([
      'code' => $data['code'],
      'qty' => $data['qty'],
      'price' => $data['price'],
    ]);

    return $purchase->load('hasProduct');
  }

  public function list(int $size)
  {
    return Purchase::withTrashed()
        ->with(['hasProduct' => function($q) {
          $q->withTrashed();
        }])
        ->paginate($size);
  }

  public function detail(string $id)
  {
    return Purchase::withTrashed()
        ->where('id', $id)
        ->with(['hasProduct' => function($q) {
          $q->withTrashed();
        }])
        ->firstOrFail();
  }

  public function update(Purchase $data, array $newData)
  {
    $data->update($newData);

    $data->refresh();

    return $data->load('hasProduct');
  }

  public function delete(string $id)
  {
    return Purchase::findOrFail($id)->delete();
  }
}