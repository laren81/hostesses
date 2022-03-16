<?php
namespace App\Repositories\Interfaces;

interface EventRepositoryInterface
{
  
    public function getEvents();
    
    public function findEvent($id);
    
    public function getClientEvents($client_id);
    
    public function createEvent($request);
    
    public function updateEvent($event, $request);
    
    public function deleteEvent($event);
    
    public function confirmEvent($event);
    
    public function getEventPrices($event);    
    
    public function sendJobProposals($event);    
    
    public function getUninvoicedEvents();
    
    public function getEventPositions($event_id);
    
    public function getEventPositionsWithPrices($event,$prices);
    
    public function findJob($id);
    
}
