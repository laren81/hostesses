<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index(){
        $jobs = $this->jobRepository->getHostessJobs(auth()->user()->id);
        $regions = $this->regionRepository->all();
        $cities = $this->cityRepository->getHostessJobCities(auth()->user()->id);
        
        return view('website.hostesses.jobs', compact('jobs','regions','cities'));
    }
    
    public function reviewApplication(Request $request){
        if($job = $this->jobRepository->findJob($request->id)){
            $job->status = $request->status;
            $job->save();
            
            if($job->status==2){
                $this->jobRepository->cancelConcurrentJobs($job);

                if($job->event_position->staff_number==count($job->event_position->jobs->where('status',2))){
                    foreach($job->event_position->jobs->where('status',1) as $current_job){
                        $current_job->status=6;
                        $current_job->save();
                    }
                    $job->event_position->event->status=3;
                    $job->event_position->event->save();                    
                }                
            }
            
            return response()->json(['success' => 'Application '.($request->status==2 ? 'accepted' : 'rejected').'!']);
        }
        return response()->json(['warning' => 'Application not found']);        
    }
    
    public function replyJobProposal(Request $request){
        $id=$request->id;
        
        if($job = $this->jobRepository->findJob($request->id)){
            $job->status = $request->status;
            $job->hostess_comment = $request->note;
            $job->extra_charge = $request->additional_charge!=0 ? $request->additional_charge : null;
            $job->save();
            
            return response()->json(['success' => 'Job proposal '.($request->status==1 ? 'accepted' : 'rejected').'!']);
        }
        
        return response()->json(['warning' => 'Job proposal not found']);
    } 
    
}
