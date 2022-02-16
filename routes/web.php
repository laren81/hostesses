<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Website\WebsiteController;
use App\Http\Controllers\Website\UserController;
use App\Http\Controllers\Website\EventController;
use App\Http\Controllers\Website\JobController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\CityController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


/*Route::middleware(['guest'])->group(function () {
    Route::get('/', function () {
        return view('auth.login');
    });
});*/

require __DIR__.'/auth.php';

Route::get('/', [WebsiteController::class,'index'])->name('home');

Route::get('/home', [WebsiteController::class,'index'])->name('home');

Route::group(['middleware' => ['guest']], function(){
    
    Route::get('users/create_hostess', [UserController::class,'createHostess'])->name('users.create_hostess');
    
    Route::post('users/store_hostess', [UserController::class,'storeHostess'])->name('users.store_hostess');
    
    Route::get('users/create_client', [UserController::class,'createClient'])->name('users.create_client');
    
    Route::post('users/store_client', [UserController::class,'storeClient'])->name('users.store_client');
});

Route::group(['middleware' => ['auth']], function(){
    
    Route::get('create_role_profile', [UserController::class,'createUserProfile'])->name('create_role_profile');
    
    Route::post('create_client_profile', [UserController::class,'createClientProfile'])->name('users.create_client_profile');
    
    Route::post('store_client_profile/{id}', [UserController::class,'storeClientProfile'])->name('users.store_client_profile');
    
    Route::post('create_hostess_profile', [UserController::class,'createHostessProfile'])->name('users.create_hostess_profile');
    
    Route::post('store_hostess_profile/{id}', [UserController::class,'storeHostessProfile'])->name('users.store_hostess_profile');
    
    Route::group(['middleware' => ['profile_completed']], function(){
        
        Route::get('images/{filename}', function ($filename)
        {
                $path = storage_path('app/public/uploads/images/'. $filename);

                if (! File::exists($path)){
                    abort(404); // todo: return default image
                }

                $file = File::get($path);
                $type = File::mimeType($path);

                $response = Response::make($file, 200);
                $response->header('Content-Type', $type);

                return $response;
        });

        Route::get('images/thumbs/{filename}', function ($filename)
        {
            $path = storage_path('app/public/uploads/images/thumbs/'.$filename);

            if (! File::exists($path)){
                abort(404); // todo: return default image
            }

            $file = File::get($path);
            $type = File::mimeType($path);

            $response = Response::make($file, 200);
            $response->header('Content-Type', $type);

            return $response;
        });

        Route::post('/delete_image', [ImageController::class, 'deleteImage'])->name('delete_image');

        Route::get('users/{id}/show', [UserController::class,'showUser'])->name('users.show');



        //Client routes
        Route::get('clients/{id}/edit', [UserController::class,'editClient'])->name('clients.edit');

        Route::patch('clients/{id}/update', [UserController::class,'updateClient'])->name('clients.update');




        //Hostess routes
        Route::get('hostesses/{id}', [UserController::class,'showHostess'])->name('hostesses.show');
        
        Route::get('hostesses/{id}/edit', [UserController::class,'editHostess'])->name('hostesses.edit');

        Route::patch('hostesses/{id}/update', [UserController::class,'updateHostess'])->name('hostesses.update');
        
        Route::get('jobs', [JobController::class,'index'])->name('jobs.index')->middleware(['role:Hostess']);
        
        Route::post('reply_job_proposal', [JobController::class,'replyJobProposal'])->name('reply_job_proposal')->middleware(['role:Hostess']);

        //Events routes 
        Route::get('events', [EventController::class,'index'])->name('events.index');

        Route::get('events/create', [EventController::class,'create'])->name('events.create')->middleware(['role:Client']);

        Route::post('events/store', [EventController::class,'store'])->name('events.store')->middleware(['role:Client']);

        Route::get('events/{id}', [EventController::class,'show'])->name('events.show')->middleware(['role:Client']);       

        Route::get('events/{id}/edit', [EventController::class,'edit'])->name('events.edit')->middleware(['role:Client']);

        Route::patch('events/{id}', [EventController::class,'update'])->name('events.update')->middleware(['role:Client']);

        Route::post('delete_event', [EventController::class,'destroy'])->name('delete_event')->middleware(['role:Client']);
        
        Route::get('event_offers/{id}', [EventController::class,'showOffer'])->name('event_offers.show')->middleware(['role:Client']);
        
        Route::post('accept_offer', [EventController::class,'acceptOffer'])->name('accept_offer')->middleware(['role:Client']);
        
        Route::post('review_application', [JobController::class,'reviewApplication'])->name('review_application')->middleware(['role:Client']);
        
        
        
    });
});

//Region routes
    Route::post('get_region_cities', [CityController::class,'getRegionCities'])->name('get_region_cities');