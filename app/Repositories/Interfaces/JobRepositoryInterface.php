<?php
namespace App\Repositories\Interfaces;

interface JobRepositoryInterface
{
    public function findJob($id);
    
    public function getEventJobs($event_id);
    
    public function getHostessJobs($id);
    
    public function cancelConcurrentJobs($job);
    
    public function findHostessJob($request);
}
