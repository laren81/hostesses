<?php
namespace App\Repositories\Interfaces;

interface UserRepositoryInterface
{
   public function all();
   
   public function createUser($input);
   
   public function findUser($id);
   
   public function updateUser($user,$request);
   
   public function deleteUser($user);
   
   public function getUsers();
   
   public function getRoleUsers($role_name);
}
