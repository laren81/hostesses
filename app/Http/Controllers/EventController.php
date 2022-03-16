<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\EventRequest;


use DataTables;


class EventController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){ 
        $clients = $this->clientRepository->all();
        $regions = $this->regionRepository->all();
        //$cities = $this->cityRepository->all();
        $cities = $this->cityRepository->eventCities();
        
        return view('events.index', compact('clients','regions','cities'));
    }
    
    public function getEvents(){
        $events = $this->eventRepository->getEvents();
        
        return DataTables::of($events)->make(true);
    }
    
    public function create(){
        $clients = $this->clientRepository->all();
        $regions = $this->regionRepository->all();
        $cities = $this->cityRepository->all();
        
        return view('events.create',compact('clients','regions','cities'));        
    }
    
    public function store(EventRequest $request){
        $result = $this->eventRepository->createEvent($request);

        if($result===true){
            return redirect()->route('admin.events.index')->with('success','Event was created');
        }  

        if(is_object($result)){
            return redirect()->back()->withInput($request->all())->with('errors',$result);
        }

        return redirect()->back()->withInput($request->all())->with('warning',$result);
    }
    
    public function show($id){
        if($event = $this->eventRepository->findEvent($id)){
            
            //print_r($event->positions[0]->hostesses()->toArray());exit;
            return view('events.show', compact('event'));
        }
        else{
            return redirect()->route('admin.events.index')->with('warning','Event was not found');
        }
    }
    
    public function edit($id){
        if($event = $this->eventRepository->findEvent($id)){            
            $clients = $this->clientRepository->all();
            $regions = $this->regionRepository->all();
            $cities = $this->cityRepository->all();
            
            return view('events.edit', compact('event','clients','regions','cities'));
        }
        else{
            return redirect()->route('admin.events.index')->with('warning','Event was not found.');
        }
    }
    
    public function update(EventRequest $request,$id){
        if($event = $this->eventRepository->findEvent($id)){
            if($this->eventRepository->updateEvent($event,$request)){
                
                return redirect()->route('admin.events.index')->with('success','Event was changed!');
            }
            else{
                return redirect()->route('admin.events.index')->with('warning','Event was not changed!');
            }
        }
        return redirect()->route('admin.events.index')->with('warning','Event was not found');
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
    
    public function confirmEvent(Request $request){
        $id = $request->get('id');
                
        if($event = $this->eventRepository->findEvent($id)){
            if($this->eventRepository->confirmEvent($event)){
            
                return response()->json(['success' => 'Event was confirmed']);
            }  

            else{
                return response()->json(['warning' => 'Event was not confirmed']);
            }
        }
        return response()->json(['warning' => 'Event was not found']);
    }
    
    public function eventJobs($event_id){
        if($event = $this->eventRepository->findEvent($event_id)){
            $jobs = $this->jobRepository->getEventJobs($event_id);
            $positions = $this->eventRepository->getEventPositions($event_id);

            return view('events.event_jobs', compact('event','jobs','positions'));
        }
        else{
            return redirect()->route('admin.events.index')->with('warning','Event was not found!');
        }
    }
    
    public function getEventInvoices(Request $request){
        $id = $request->id;
        
        return $this->invoiceRepository->getEventInvoices($id);
    }
    
    public function getClientEvents(Request $request){
        $client_id = $request->client;
        
        $events = $this->eventRepository->getClientEvents($client_id);
        
        return $events;
    }
    
    public function changeJobStatus(Request $request){
        if($job = $this->jobRepository->findJob($request->id)){
            $job->status= $request->status;
            $job->admin_comment = $request->comment;
            $job->save();
            
            return response()->json(['success' => 'Job status updated']);
        }
        
        return response()->json(['warning' => 'Job was not found']);
    }
}