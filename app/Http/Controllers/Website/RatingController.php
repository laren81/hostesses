<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function ratePersonnel($id){
        if($event = $this->eventRepository->findEvent($id)){
            $positions = $this->eventRepository->getEventPositionsWithJobs($event->id);
            
            return view('website.events.rate_personnel', compact('event','positions'));
        }
        return redirect()->route('events.index')->with('warning','Event was not found');
    }
    
    public function storeRating(Request $request){
        if($job = $this->jobRepository->findHostessJob($request)){
            if($this->ratingRepository->createRating($request)){
                return redirect()->route('ratings.create',$job->event_position->event_id)->with('success','Rating created');
            }
            
            return redirect()->route('ratings.create')->with('warning','Rating not created');
        }
        return redirect()->back()->with('warning','Job not found');
    }
}
