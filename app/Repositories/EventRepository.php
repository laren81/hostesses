<?php

namespace App\Repositories;

use App\Models\Event;
use App\Models\EventPosition;
use App\Models\Price;
use App\Models\Hostess;
use App\Models\Job;
use Mail;

use App\Repositories\Interfaces\EventRepositoryInterface;

use DB;
use DateTime;
use Carbon\Carbon;

class EventRepository implements EventRepositoryInterface
{
    public function getEvents(){
        return Event::with('offer')->leftJoin(DB::raw("(select event_id, count(id) as count_invoices from invoices group by event_id) as temp"),'temp.event_id','=','events.id')->leftJoin('clients','clients.id','=','events.client_id')->leftJoin('regions','regions.id','=','events.region_id')->leftJoin('cities','cities.id','=','events.city_id')->select(['events.*',DB::raw('date_format(events.date_from,"%d.%m.%Y") as date_from'),DB::raw('date_format(events.date_to,"%d.%m.%Y") as date_to'),'clients.company_name as client','regions.name as region','cities.name as city','cities.zip as zip',DB::raw('ifnull(count_invoices,0) as count_invoices')])->get();
    }
    
    public function getClientEvents($client_id){
        return Event::where('client_id',$client_id)->get();
    }
    
    public function findEvent($id){
        return Event::find($id);
    }
    
    public function createEvent($request){
        $input = $request->all();

        DB::beginTransaction();
        
        try{
            
            $input['urgent'] = (strtotime($input['date_from'].' '.$input['time_from']) - strtotime(Carbon::now()))/(60*60)<72 ? 1 : 0;
            
            $input['date_from'] = date_format(new DateTime($input['date_from']), 'Y-m-d');
            $input['date_to'] = date_format(new DateTime($input['date_to']), 'Y-m-d');
            
            
            $event = Event::create($input);
            
            foreach($input['positions'] as $position){
                $position['date_from'] = isset($position['date_from']) ? date_format(new DateTime($position['date_from']), 'Y-m-d') : null;
                $position['date_to'] = isset($position['date_to']) ?  date_format(new DateTime($position['date_to']), 'Y-m-d') : null;           
                $position['event_id'] = $event->id;
                
                EventPosition::create($position);
            }
            
            DB::commit();
                
        } catch (Exception $ex) {
            DB::rollBack();
            return $ex->getMessage();            
        }        
        
        return true;
    }
    
    public function updateEvent($event, $request){
        $input = $request->all();

        DB::beginTransaction();
        
        try{
            
            $input['date_from'] = date_format(new DateTime($input['date_from']), 'Y-m-d');
            $input['date_to'] = date_format(new DateTime($input['date_to']), 'Y-m-d');
            $input['region_id'] = $input['internal_location']==1 ? $input['region_id'] : 0;
            $input['city_id'] = $input['internal_location']==1 ? $input['city_id'] : 0;
            
            $event->update($input);
            
            $event->positions()->delete();
            
            foreach($input['positions'] as $position){
                $position['date_from'] = isset($position['date_from']) ? date_format(new DateTime($position['date_from']), 'Y-m-d') : null;
                $position['date_to'] = isset($position['date_to']) ?  date_format(new DateTime($position['date_to']), 'Y-m-d') : null;           
                $position['event_id'] = $event->id;
                
                EventPosition::create($position);
            }
            
            DB::commit();
                
        } catch (Exception $ex) {
            DB::rollBack();
            return $ex->getMessage();            
        }        
        
        return true;
    }
    
    public function deleteEvent($event){
        return $event->delete();
    }
    
    public function confirmEvent($event){
        $event->status = 1;
        
        $event->save();
        
        return true;
    }
    
    public function getEventPrices($event) {
        
        $price = Price::where('region_id',$event->region_id)->get()->first();
        
        return $price;
    }    
    
    public function sendJobProposals($event) {

        foreach($event->hostesses() as $hostess_id){
            
            $hostess = Hostess::find($hostess_id);
            
            $hostess_event_positions = array();

            foreach($event->positions as $position){
                if(in_array($hostess_id,$position->hostesses()->pluck('id')->toArray())){
                    array_push($hostess_event_positions,$position->id);
                }
                
                $hostess->event_positions = $hostess_event_positions;
            }         
            
            try{                
                /*Mail::send('emails.job_offer', ['hostess' => $hostess, 'event' => $event], function ($message) use ($hostess){
                            $message->from('kiro@hostess-agency.eu', 'Messehostessen');
                            $message->subject('Messehostessen job offer');
                            $message->to($hostess->user->email);
                });*/
                
                foreach($hostess_event_positions as $hostess_event_position){
                    Job::create([
                        'user_id' => $hostess->user_id,
                        'event_position_id' => $hostess_event_position,
                        'status' => 0
                    ]);
                }
                
                $event->status = 2;
                $event->save();
            }
            catch(Exceptoin $e){
                Log::debug('Error sending job offer e-mail. '.$e->getMessage());
            } 
            
        }
            
        return true;
    }
    
    public function getUninvoicedEvents(){
        $events = Event::whereHas('offer', function ($query) {return $query->where('accepted', '=', 1);})->whereDoesntHave('offer.invoice')->select('events.*')->get();
        return $events;
    }
    
    public function getEventPositions($vent_id){
        
        return EventPosition::where('event_id',$vent_id)->get();
    }
    
    public function getEventPositionsWithPrices($event,$prices) {
        $positions = EventPosition::where('event_id',$event->id)->get();
        
        foreach($positions as &$position){
            $position->staff_days = $position->days();
            $position->staff_hours = $position->hours();            
            $position->booking_charge = $position->charge();      
            
            $position->staff_wages = $position->wages($raw_wages = $position->staff_type==1 ? $prices['H'.(min($position->staff_number,10))] : ($position->staff_type==2 ? $prices['M'.(min($position->staff_number,10))] : $prices['S'.(min($position->staff_number,10))]));
        }
        
        return $positions;
    }
    
    public function getEventPositionsWithJobs($event_id){
        $positions = EventPosition::with('jobs.user.hostess')->where('event_id',$event_id)->get();
        
        return $positions;
    }
    
    public function findJob($id){
        return Job::find($id);
    }
}