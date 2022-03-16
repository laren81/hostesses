<?php

namespace App\Repositories;

use App\Models\Job;

use App\Repositories\Interfaces\JobRepositoryInterface;

use DB;

class JobRepository implements JobRepositoryInterface
{
    
    public function findJob($id){
        return Job::find($id);
    }
    
    public function getEventJobs($event_id){
        $jobs = Job::leftJoin('users','users.id','=','jobs.user_id')->leftJoin('event_positions','event_positions.id','=','jobs.event_position_id')->where('event_positions.event_id',$event_id)->select(['jobs.*','users.first_name','users.last_name'])->get();
        
        return $jobs;
    }
    
    public function getHostessJobs($id){
        $jobs = Job::with('event_position.event.client')->leftJoin('users','users.id','=','jobs.user_id')->leftJoin('event_positions','event_positions.id','=','jobs.event_position_id')->leftJoin('event_offer_rows','event_offer_rows.event_position_id','=','event_positions.id')->where('jobs.user_id',$id)->select(['jobs.*','users.first_name','users.last_name','event_offer_rows.staff_wages','event_positions.date_from','event_positions.date_to','event_positions.time_from','event_positions.time_till'])->get();
 
        return $jobs;
    }
    
    public function cancelConcurrentJobs($job) {
        $date_from = $job->event_position->date_from!=null ? $job->event_position->date_from : $job->event_position->event->date_from;
        $date_to = $job->event_position->date_to!=null ? $job->event_position->date_to : $job->event_position->event->date_to;
        
        $time_from = $job->event_position->time_from!=null ? $job->event_position->time_from : $job->event_position->event->time_from;
        $time_till = $job->event_position->time_till!=null ? $job->event_position->time_till : $job->event_position->event->time_till;
        
        $concurrent_jobs = Job::leftJoin('event_positions as ep','ep.id','=','jobs.event_position_id')
            ->leftJoin('events','events.id','=','ep.event_id')
            ->leftJoin('cities','cities.id','=','events.city_id')
            ->leftJoin('hostesses','hostesses.user_id','=','jobs.user_id')
            ->where('jobs.id','!=',$job->id)->where('jobs.user_id',$job->user_id)->where(function($q){$q->where('jobs.status',0);$q->orWhere('jobs.status',1);})
            ->select(['jobs.id','jobs.user_id','jobs.event_position_id','events.city_id','internal_location','driver_licence','own_car',
                        DB::raw('case when ep.date_from IS NOT NULL then ep.date_from ELSE events.date_from end as job_date_from'),
                        DB::raw('case when ep.date_to IS NOT NULL then ep.date_to ELSE events.date_to end as job_date_to'),
                        DB::raw('case when ep.time_from IS NOT NULL then ep.time_from ELSE events.time_from end as job_time_from'),
                        DB::raw('case when ep.time_till IS NOT NULL then ep.time_till ELSE events.time_till end as job_time_till'),
                        DB::raw("CONCAT(case when ep.date_from IS NOT NULL then ep.date_from ELSE events.date_from end,' ',case when ep.time_from IS NOT NULL then ep.time_from ELSE events.time_from END) AS timestamp_from"),
                        DB::raw("CONCAT(case when ep.date_to IS NOT NULL then ep.date_to ELSE events.date_to end,' ',case when ep.time_till IS NOT NULL then ep.time_till ELSE events.time_till END) AS timestamp_to"),
                        DB::raw("case when events.city_id!=".$job->event_position->event->city_id." and events.city_id!=0 then ACOS(SIN(RADIANS(cities.lat))*SIN(RADIANS('".$job->event_position->event->city->lat."')) + COS(RADIANS(cities.lat)) * COS(RADIANS('".$job->event_position->event->city->lat."')) * COS(RADIANS(cities.lng) - RADIANS('".$job->event_position->event->city->lng."')) ) * 6380 ELSE 0 end AS distance")
            ])
            ->havingRaw("(((job_date_from<='".$date_from."' AND job_date_to>='".$date_from."') or (job_date_from>='".$date_from."' AND job_date_from<='".$date_to."')) AND (internal_location=2 OR (internal_location=1 AND (((DATE_add(job_time_from, INTERVAL 2 HOUR)<='".$time_from."' AND DATE_add(job_time_till, INTERVAL 2 HOUR)>='".$time_from."') OR (DATE_add(job_time_from, INTERVAL 2 HOUR)>='".$time_from."' AND DATE_add(job_time_from, INTERVAL 2 HOUR)<='".$time_till."')) OR distance>(case when hostesses.driver_licence=1 and hostesses.own_car=1 then 200 else 50 end)))))")        
            ->get();
            
        foreach($concurrent_jobs as $concurrent_job){
            $concurrent_job->status = 6;
            $concurrent_job->save();
        }    
            
        return true;
    }
    
    public function findHostessJob($request){
        return Job::where('id',$request->job_id)->where('user_id',$request->user_id)->first();
    }
}
