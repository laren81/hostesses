<?php
namespace App\Repositories\Interfaces;

interface EventOfferRepositoryInterface
{ 
    public function findOffer($id); 
    
    public function getEventOffers();    
    
    public function createEventOffer($request,$event);   
    
    public function updateEventOffer($event_offer, $request);
    
    public function getInvoiceOffer($event_offer_id);
}