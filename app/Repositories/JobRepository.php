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
        
        $concurrent_jobs = Job::leftJoin('event_positions as ep','ep.id','=','jobs.event_position_id')->leftJoin('events','events.id','=','ep.event_id')
                ->where('jobs.id','!=',$job->id)->where('jobs.user_id',$job->user_id)->where(function($q){$q->where('jobs.status',0);$q->orWhere('jobs.status',1);})
                ->select(['jobs.id','jobs.user_id','jobs.event_position_id','city_id',
                            DB::raw('case when ep.date_from IS NOT NULL then ep.date_from ELSE events.date_from end as job_date_from'),
                            DB::raw('case when ep.date_to IS NOT NULL then ep.date_to ELSE events.date_to end as job_date_to'),
                            DB::raw('case when ep.time_from IS NOT NULL then ep.time_from ELSE events.time_from end as job_time_from'),
                            DB::raw('case when ep.time_till IS NOT NULL then ep.time_till ELSE events.time_till end as job_time_till'),
                            DB::raw("CONCAT(case when ep.date_from IS NOT NULL then ep.date_from ELSE events.date_from end,' ',case when ep.time_from IS NOT NULL then ep.time_from ELSE events.time_from END) AS timestamp_from"),
                            DB::raw("CONCAT(case when ep.date_to IS NOT NULL then ep.date_to ELSE events.date_to end,' ',case when ep.time_till IS NOT NULL then ep.time_till ELSE events.time_till END) AS timestamp_to")
                        ])
                ->havingRaw("(TIMESTAMPDIFF(HOUR,timestamp_to,'".($job->event_position->date_from!=null ? $job->event_position->date_from : $job->event_position->event->date_from)." ".($job->event_position->time_from!=null ? $job->event_position->time_from : $job->event_position->event->time_from)."')<2 and TIMESTAMPDIFF(HOUR,'".($job->event_position->date_to!=null ? $job->event_position->date_to : $job->event_position->event->date_to)." ".($job->event_position->time_till!=null ? $job->event_position->time_till : $job->event_position->event->time_till)."',timestamp_from)<2))")
                ->get();                

        foreach($concurrent_jobs as $index=>$concurrent_job){
            if((round(((strtotime($job->event_position->time_from!=null ? $job->event_position->time_from : $job->event_position->event->time_from)) - strtotime($concurrent_job->job_time_till)) / 3600,2)+2>=0 ||
                round((strtotime($concurrent_job->job_time_from) - strtotime(($job->event_position->time_till!=null ? $job->event_position->time_till : $job->event_position->event->time_till))) / 3600,2)+2>=0)
            ){
                unset($concurrent_jobs[$index]);
            }
            else{
                
                $concurrent_job->status=6;
                $concurrent_job->save();
            }
        }
        return true;
    }
}
