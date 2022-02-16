<?php

namespace App\Repositories;

use App\Models\EventOffer;
use App\Models\EventOfferRow;

use Mail;

use App\Repositories\Interfaces\EventOfferRepositoryInterface;

use DB;

class EventOfferRepository implements EventOfferRepositoryInterface
{

    public function findOffer($id){
        
        return EventOffer::find($id);
    }
    
    public function getEventOffers(){
       return EventOffer::with('invoice')->leftJoin('events','events.id','=','event_offers.event_id')->leftJoin('clients','clients.id','=','events.client_id')->select(['event_offers.*','events.name','events.status','clients.company_name as client'])->get();
    }
    
    public function createEventOffer($request,$event){
        $input = $request->all();

        DB::beginTransaction();
        
        try{
            
            $offer = EventOffer::create($input);
            
            foreach($input['position_id'] as $index=>$value){
                $input_array = [
                    'event_offer_id' => $offer->id,
                    'event_position_id' => $input['position_id'][$index],
                    'days' => $input['days'][$index],
                    'staff_wages' => $input['staff_wages'][$index],
                    'booking_charge' => $input['booking_charge'][$index],
                    'additional_charge' => $input['additional_charge'][$index] ?? 0,
                    'total' => $input['days'][$index]*($input['staff_wages'][$index] + $input['booking_charge'][$index] + ($input['additional_charge'][$index] ?? 0)),
                    'client_note' => $input['client_note'][$index] ?? null,
                    'admin_note' => $input['admin_note'][$index] ?? null,
                ];
                
                EventOfferRow::create($input_array);
            }
            
            $event->status=1;
            $event->save();

            //$this->sendOfferEmail($event->client->user->email, $offer);            
                
            DB::commit();
                
        } catch (Exception $ex) {
            DB::rollBack();
            return $ex->getMessage();            
        }        
        
        return true;
    }
    
    public function updateEventOffer($offer, $request){
        $input = $request->all();

        DB::beginTransaction();
        
        try{
            
            $offer->update($input);
            
            $offer->rows()->delete();
            
            foreach($input['position_id'] as $index=>$value){
                $input_array = [
                    'event_offer_id' => $offer->id,
                    'event_position_id' => $input['position_id'][$index],
                    'days' => $input['days'][$index],
                    'staff_wages' => $input['staff_wages'][$index],
                    'booking_charge' => $input['booking_charge'][$index],
                    'additional_charge' => $input['additional_charge'][$index] ?? 0,
                    'total' => $input['days'][$index]*($input['staff_wages'][$index] + $input['booking_charge'][$index] + ($input['additional_charge'][$index] ?? 0)),
                    'client_note' => $input['client_note'][$index] ?? null,
                    'admin_note' => $input['admin_note'][$index] ?? null,
                ];
                
                EventOfferRow::create($input_array);
            }

            $this->sendOfferEmail($offer->event->client->user->email, $offer);            
                
            DB::commit();
                
        } catch (Exception $ex) {
            DB::rollBack();
            return $ex->getMessage();            
        }        
        
        return true;
    }
    
    private function sendOfferEmail($email,$offer){
                
        try{
            Mail::send('emails.offer_sent', ['offer' => $offer,], function ($message) use ($email){
                        $message->from('kiro@hostess-agency.eu', 'Messehostessen');
                        $message->subject('Messehostessen quote');
                        $message->to($email);
            });
        }
        catch(Exceptoin $e){
            Log::debug('Error sending confirmation e-mail. '.$e->getMessage());
        }            
            
        return true;
    }    
    
    public function getInvoiceOffer($event_offer_id) {
        $event_offer = EventOffer::with('rows')->with('event')->with('event.client')->with('event.positions')->where('event_offers.id',$event_offer_id)->get()->first();

        foreach($event_offer->rows as $row){            
            $row->service = $row->event_position->description();            
            $row->count_hosteses = $row->event_position->staff_number;
        }
        return $event_offer;
    }
}