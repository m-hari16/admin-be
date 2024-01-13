<?php

namespace App\Http\Repositories;

use App\Models\Category;

class CategoryRepository
{
  public function saveCategory(array $categoryData)
  {
    return Category::create($categoryData);
  }

  public function listCategory(int $size)
  {
    return Category::paginate($size);
  }

  public function detailCategory(string $id)
  {
    return Category::where('id', $id)->firstOrFail();
  }

  public function updateCategory(Category $categoryData, array $newData)
  {
    $categoryData->name = $newData["name"];
    $categoryData->save();

    return $categoryData;
  }

  public function delete(string $id)
  {
  return Category::findOrFail($id)->delete();
  }
}