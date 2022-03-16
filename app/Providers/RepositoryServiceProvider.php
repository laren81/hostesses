<?php 

namespace App\Providers; 


use App\Repositories\Interfaces\UserRepositoryInterface; 
use App\Repositories\Interfaces\RoleRepositoryInterface; 
use App\Repositories\Interfaces\HostessRepositoryInterface; 
use App\Repositories\Interfaces\ClientRepositoryInterface;
use App\Repositories\Interfaces\EventRepositoryInterface;
use App\Repositories\Interfaces\EventOfferRepositoryInterface;
use App\Repositories\Interfaces\PriceRepositoryInterface;
use App\Repositories\Interfaces\RegionRepositoryInterface;
use App\Repositories\Interfaces\CityRepositoryInterface;
use App\Repositories\Interfaces\JobRepositoryInterface;
use App\Repositories\Interfaces\InvoiceRepositoryInterface;
use App\Repositories\Interfaces\RatingRepositoryInterface;

use App\Repositories\UserRepository;
use App\Repositories\RoleRepository;
use App\Repositories\HostessRepository;
use App\Repositories\ClientRepository;
use App\Repositories\EventRepository;
use App\Repositories\EventOfferRepository;
use App\Repositories\PriceRepository;
use App\Repositories\RegionRepository;
use App\Repositories\CityRepository;
use App\Repositories\JobRepository;
use App\Repositories\InvoiceRepository;
use App\Repositories\RatingRepository;

use Illuminate\Support\ServiceProvider; 

/** 
* Class RepositoryServiceProvider 
* @package App\Providers 
*/ 
class RepositoryServiceProvider extends ServiceProvider 
{ 
   /** 
    * Register services. 
    * 
    * @return void  
    */ 
   public function register() 
   { 
       $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
       $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
       $this->app->bind(HostessRepositoryInterface::class, HostessRepository::class);
       $this->app->bind(ClientRepositoryInterface::class, ClientRepository::class);
       $this->app->bind(EventRepositoryInterface::class, EventRepository::class);
       $this->app->bind(EventOfferRepositoryInterface::class, EventOfferRepository::class);
       $this->app->bind(PriceRepositoryInterface::class, PriceRepository::class);
       $this->app->bind(RegionRepositoryInterface::class, RegionRepository::class);
       $this->app->bind(CityRepositoryInterface::class, CityRepository::class);
       $this->app->bind(JobRepositoryInterface::class, JobRepository::class);
       $this->app->bind(InvoiceRepositoryInterface::class, InvoiceRepository::class);
       $this->app->bind(RatingRepositoryInterface::class, RatingRepository::class);
   }
}