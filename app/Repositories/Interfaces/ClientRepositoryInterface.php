<?php
namespace App\Repositories\Interfaces;

interface ClientRepositoryInterface
{
    public function all();
    
    public function findUserClient($user_id);
    
    public function findClient($id);
    
    public function createClient($request); 
    
    public function updateClient($client,$request);
    
    public function createClientProfile($user,$request);
  
}
