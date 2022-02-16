<?php
namespace App\Repositories\Interfaces;

interface HostessRepositoryInterface
{
  
    public function findHostess($id);
    
    public function findUserHostess($user_id);
    
    public function createHostess($request); 
    
    public function updateHostess($hostess,$request);
    
    public function createHostessProfile($user,$request);
  
}
