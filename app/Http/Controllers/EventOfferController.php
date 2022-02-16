<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\EventOfferRequest;

use DataTables;

class EventOfferController extends Controller
{
    public function index(){
        $clients = $this->clientRepository->all();
        
        return view('event_offers.index', compact('clients'));
    }
    
    public function getEventOffers(){
        $event_offers = $this->eventOfferRepository->getEventOffers();
        
        return DataTables::of($event_offers)->make(true);
    }
    
    public function create($id){
        if($event = $this->eventRepository->findEvent($id)){
            
            if($event->offer){
                return redirect()->route('admin.events.index')->with('warning','Event offer already created');
            }
            $prices = $this->eventRepository->getEventPrices($event);
            $positions = $this->eventRepository->getEventPositionsWithPrices($event,$prices);

            return view('event_offers.create', compact('event','prices','positions'));
        }
        return redirect()->route('admin.events.index')->with('warning','Event was not found');
    }
    
    public function store(EventOfferRequest $request){
        if($event = $this->eventRepository->findEvent($request->event_id)){     
            
            $result = $this->eventOfferRepository->createEventOffer($request,$event);

            if($result===true){
                return redirect()->route('admin.events.index')->with('success','Event offer was created');
            }  

            if(is_object($result)){
                return redirect()->back()->withInput($request->all())->with('errors',$result);
            }
        }
        else{
            return redirect()->route('admin.events.index')->with('warning','Event was not found.');
        }
    }
    
    public function sentOffer($id){
        $offer = $this->eventOfferRepository->findOffer($id);
        
        return view('emails.offer_sent', compact('offer'));
    }
    
    public function show($id){
        $offer = $this->eventOfferRepository->findOffer($id);
        
        return view('event_offers.show', compact('offer'));
    }
    
    public function edit($id){
        if($offer = $this->eventOfferRepository->findOffer($id)){
            $event = $offer->event;
                    
            return view('event_offers.edit', compact('offer','event'));
        }
        else{
            return redirect()->route('admin.events.index')->with('warning','Event was not found.');
        }
    }
    
    public function update(EventOfferRequest $request,$id){
        if($event_offer = $this->eventOfferRepository->findOffer($id)){
            if($this->eventOfferRepository->updateEventOffer($event_offer,$request)){
                
                return redirect()->route('admin.events.index')->with('success','Event offer was changed!');
            }
            else{
                return redirect()->route('admin.events.index')->with('warning','Event offer was not changed!');
            }
        }
        return redirect()->route('admin.events.index')->with('warning','Event offer was not found');
    }
}
