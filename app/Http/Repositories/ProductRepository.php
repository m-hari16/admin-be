<?php

namespace App\Http\Repositories;

use App\Models\Category;
use App\Models\Product;

class ProductRepository
{
  public function save(array $data)
  {
    $category = Category::where('id', $data["category_id"])->firstOrFail();

    $product = $category->hasProduct()->create([
      'code' => $data['code'],
      'name' => $data['name'],
      'specification' => isset($data['specification']) ? json_encode($data['specification']) : json_encode([]),
      'uom' => $data['uom'],
      'isActive' => $data['isActive'],
    ]);

    $product->hasStock()->create([
      'qty' => 0
    ]);

    return $product->load('hasCategory', 'hasStock');
  }

  public function list(int $size)
  {
    return Product::with(['hasCategory', 'hasStock'])->paginate($size);
  }

  public function detail(string $id)
  {
    return Product::where('id', $id)->with(['hasCategory', 'hasStock'])->firstOrFail();
  }

  public function update(Product $data, array $newData)
  {
    $data->update($newData);

    $data->refresh();

    return $data->load('hasCategory', 'hasStock');
  }

  public function delete(string $id)
  {
    return Product::findOrFail($id)->delete();
  }
}