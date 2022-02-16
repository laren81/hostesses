<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\EventRequest;

class EventController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){        
        if(auth()->user()->role_id==2 && $hostes = $this->hostessRepository->findUserHostess(auth()->user()->id)){
            $events = $this->eventRepository->getClientEvents($hostes->id);
            $cities = $this->cityRepository->all();
        }        
        else if(auth()->user()->role_id==3 && $client = $this->clientRepository->findUserClient(auth()->user()->id)){
            $events = $this->eventRepository->getClientEvents($client->id);
            $cities = $this->cityRepository->getClientEventsCities($client->id);
        }
                
        else{
            return redirect()->route('home');
        }        
        
        $regions = $this->regionRepository->all();        
        
        return view('website.events.index', compact('events','regions','cities'));
    }
    
    public function create(){
        if(auth()->user()->role_id==3 && $client = $this->clientRepository->findUserClient(auth()->user()->id)){
            
            $regions = $this->regionRepository->all();
            $cities = $this->cityRepository->all();
            
            return view('website.events.create',compact('client','regions','cities'));
        }
        
         return redirect()->route('home')->with('warning','You do not have the right privileges');
    }
    
    public function store(EventRequest $request){
        $result = $this->eventRepository->createEvent($request);

        if($result===true){
            return redirect()->route('events.index')->with('success','Event was created');
        }  

        if(is_object($result)){
            return redirect()->back()->withInput($request->all())->with('errors',$result);
        }

        return redirect()->back()->withInput($request->all())->with('warning',$result);
    }
    
    public function show($id){
        if($event = $this->eventRepository->findEvent($id)){
            return view('website.events.show', compact('event'));
        }
        else{
            return redirect()->route('home')->with('warning','Event was not found');
        }
    }
    
    public function edit($id){
        if($event = $this->eventRepository->findEvent($id)){            
            
            $regions = $this->regionRepository->all();
            $cities = $this->cityRepository->all();
            
            return view('website.events.edit', compact('event','regions','cities'));
        }
        else{
            return redirect()->route('home')->with('warning','Event was not found.');
        }
    }
    
    public function update(EventRequest $request,$id){
        if($event = $this->eventRepository->findEvent($id)){
            if($this->eventRepository->updateEvent($event,$request)){
                
                return redirect()->route('events.index')->with('success','Event was changed!');
            }
            else{
                return redirect()->route('events.index')->with('warning','Event was not changed!');
            }
        }
        return redirect()->route('events.index')->with('warning','Event was not found');
    }
    
    public function destroy(Request $request){
        
        $id = $request->get('id');
                
        if($event = $this->eventRepository->findEvent($id)){
            
            if($event->status!=0){
                return response()->json(['warning' => 'You cannot delete this event. Please contact administration']);
            }
            
            if($this->eventRepository->deleteEvent($event)){
                return response()->json(['success' => 'Event was deleted!']);
            }
            else{
                return response()->json(['warning' => 'Event was not deleted!']);
            }
        }
        return response()->json(['warning' => 'Event was not found']);
    }
    
    public function showOffer($id){
        $job = $this->jobRepository->findJob(6);
        
        $offer = $this->eventOfferRepository->findOffer($id);
        
        if($offer->accepted==1){
            $positions = $this->eventRepository->getEventPositionsWithJobs($offer->event_id);
        }
        else{            
            $positions = $this->eventRepository->getEventPositions($offer->event_id);
        }
        return view('website.events.show_offer', compact('offer','positions'));
    }
    
    public function acceptOffer(Request $request){
        $id = $request->get('id');
        
        if($offer = $this->eventOfferRepository->findOffer($id)){            
            $offer->accepted = 1;
            $offer->save();
            
            $this->eventRepository->sendJobProposals($offer->event);
            
            return response()->json(['success' => 'Thank you for accepting our offer!']);
        }
        return response()->json(['warning' => 'Offer was not found']);
    }
}