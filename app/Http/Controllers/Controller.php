<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

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

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    protected $userRepository;
    protected $roleRepository;
    protected $hostessRepository;
    protected $clientRepository;
    protected $eventRepository;
    protected $eventOfferRepository;
    protected $priceRepository;
    protected $regionRepository;
    protected $cityRepository;
    protected $jobRepository;
    protected $invoiceRepository;
    
    public function __construct(UserRepositoryInterface $userRepository, 
                                RoleRepositoryInterface $roleRepository,
                                HostessRepositoryInterface $hostessRepository, 
                                ClientRepositoryInterface $clientRepository,
                                EventRepositoryInterface $eventRepository,
                                EventOfferRepositoryInterface $eventOfferRepository,
                                PriceRepositoryInterface $priceRepository,
                                RegionRepositoryInterface $regionRepository,
                                CityRepositoryInterface $cityRepository,
                                JobRepositoryInterface $jobRepository,
                                InvoiceRepositoryInterface $invoiceRepository
            ) 
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
        $this->hostessRepository = $hostessRepository;
        $this->clientRepository = $clientRepository;
        $this->eventRepository = $eventRepository;
        $this->eventOfferRepository = $eventOfferRepository;
        $this->priceRepository = $priceRepository;
        $this->regionRepository = $regionRepository;
        $this->cityRepository = $cityRepository;
        $this->jobRepository = $jobRepository;
        $this->invoiceRepository = $invoiceRepository;
    }
    
}
