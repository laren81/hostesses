<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class RemoveExpiredPromotions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remove:promotions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Removes expired promotions from objects promotions';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $expired_promotions = \DB::table('promotions')
                  ->whereRaw('Date(date_to) < CURDATE()')
                  ->whereRaw("locate(CONCAT(',',id,','),(SELECT GROUP_CONCAT(promotions) FROM objects))!=0")
                  ->get();
        
        foreach($expired_promotions as $expired_promotion){
            \DB::table('objects')->where('promotions','like','%,'.$expired_promotion->id.',%')->update(['promotions' =>DB::raw("REPLACE(promotions,',".$expired_promotion->id.",',(case when promotions=',".$expired_promotion->id.",' then null else ',' end))")]);
        }
    }
}
