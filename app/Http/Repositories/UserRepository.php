<?php

namespace App\Http\Repositories;

use App\Models\User;

class UserRepository
{
  public function saveUser(array $userData)
  {
    return User::create($userData);
  }

  public function listUser(int $size)
  {
    return User::with('hasRole')->paginate($size);
  }

  public function detailUser(int $id)
  {
    return User::where('id', $id)->with('hasRole')->firstOrFail();
  }

  public function updateUser(User $userData, array $newData)
  {
    $userData->update($newData);

    $userData->refresh();

    return $userData->load('hasRole');
  }

  public function delete(int $id)
  {
    return User::findOrFail($id)->delete();
  }
}