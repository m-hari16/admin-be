<?php

namespace App\Http\Repositories;

use App\Models\Role;

class RoleRepository
{
  public function saveRole(array $roleData)
  {
    return Role::create($roleData);
  }

  public function listRole(int $size)
  {
    return Role::paginate($size);
  }

  public function detailRole(string $id)
  {
    return Role::where('id', $id)->firstOrFail();
  }

  public function updateRole(Role $roleData, array $newData)
  {
    $roleData->name = $newData["name"];
    $roleData->save();

    return $roleData;
  }

  public function delete(string $id)
  {
  return Role::findOrFail($id)->delete();
  }
}