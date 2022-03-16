<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventOfferController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\InvoiceController;

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

Route::get('/', function () {
    return view('auth.login');
});

Route::get('password/request',[
            'as' => 'password_request', 
            'uses' => 'UsersController@requestPassword']);

Route::get('password/request/{token}', [
        'as' => 'password.new_request',
        'uses' => 'Auth\ResetPasswordController@showRequestForm']);

Route::group(['middleware' => ['auth','admin']], function()
{
    Route::get('/dashboard', [HomeController::class,'index'])->name('home');
    
    //Images and files routes
    Route::get('images/{filename}/', function ($filename)
    {
            $path = storage_path('app/public/uploads/images/'. $filename);

            if (! File::exists($path))
            {
                abort(404); // todo: return default image
            }

            $file = File::get($path);
            $type = File::mimeType($path);

            $response = Response::make($file, 200);
            $response->header('Content-Type', $type);

            return $response;
    });

    Route::get('files/{filename}/', function ($filename)
    {
            $path = storage_path('app/public/uploads/files/'. $filename);

            if (! File::exists($path))
            {
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

            if (! File::exists($path))
            {
                abort(404); // todo: return default image
            }

            $file = File::get($path);
            $type = File::mimeType($path);

            $response = Response::make($file, 200);
            $response->header('Content-Type', $type);

            return $response;
    });
    

    Route::post('/delete_image', [ImageController::class, 'deleteImage'])->name('delete_image');

    Route::post('/delete_file', [FileController::class, 'deleteFile'])->name('delete_file');
    
    
    //CKEditor routes
    
        Route::post('ckeditor/images_upload', [CKEditorController::class,'upload'])->name('images.upload');

    // Users routes

        Route::get('users', [UserController::class,'index'])->name('users.index');
        
        Route::get('users/create', [UserController::class,'create'])->name('users.create');

        Route::post('users/store', [UserController::class, 'store'])->name('users.store');
        
        Route::get('users/{id}', [UserController::class,'show'])->name('users.show');       
        
        Route::get('users/{id}/edit', [UserController::class,'edit'])->name('users.edit');

        Route::patch('users/{id}', [UserController::class,'updateUser'])->name('users.update');
        
        Route::patch('hostesses/{id}', [UserController::class,'updateHostess'])->name('hostesses.update');
        
        Route::patch('clients/{id}', [UserController::class,'updateClient'])->name('clients.update');
        
        Route::post('delete_user', [UserController::class,'destroy'])->name('delete_user');
        
        Route::post('get_users', [UserController::class,'getUsers'])->name('get_users');
        
        
    // Roles routes

        Route::get('roles', [RoleController::class,'index'])->name('roles.index');
        
        Route::get('roles/create', [RoleController::class,'create'])->name('roles.create');

        Route::post('roles/store', [RoleController::class, 'store'])->name('roles.store');
        
        Route::get('roles/{id}', [RoleController::class,'show'])->name('roles.show');       
        
        Route::get('roles/{id}/edit', [RoleController::class,'edit'])->name('roles.edit');

        Route::patch('roles/{id}', [RoleController::class,'update'])->name('roles.update');
        
        Route::post('delete_role', [RoleController::class,'destroy'])->name('delete_role');  
        
        Route::post('get_roles', [RoleController::class,'getRoles'])->name('get_roles');
        
    // Events routes

        Route::get('events', [EventController::class,'index'])->name('events.index');
        
        Route::get('events/create', [EventController::class,'create'])->name('events.create');

        Route::post('events/store', [EventController::class, 'store'])->name('events.store');
        
        Route::get('events/{id}', [EventController::class,'show'])->name('events.show');       
        
        Route::get('events/{id}/edit', [EventController::class,'edit'])->name('events.edit');

        Route::patch('events/{id}', [EventController::class,'update'])->name('events.update');
        
        Route::post('delete_event', [EventController::class,'destroy'])->name('delete_event');  
        
        Route::post('get_events', [EventController::class,'getEvents'])->name('get_events');   
        
        Route::post('confirm_event', [EventController::class,'confirmEvent'])->name('confirm_event');
        
        Route::post('get_event_invoices', [EventController::class,'getEventInvoices'])->name('get_event_invoices');
        
        Route::post('get_client_events', [EventController::class,'getClientEvents'])->name('get_client_events');
        
    //Event offers routes
        
        Route::get('event_offers', [EventOfferController::class,'index'])->name('event_offers.index');
        
        Route::get('events/{id}/create_offer', [EventOfferController::class,'create'])->name('event_offers.create');
        
        Route::get('events/offer_sent/{id}', [EventOfferController::class,'sentOffer'])->name('events.sent_offer');
        
        Route::get('event_offers/{id}', [EventOfferController::class,'show'])->name('event_offers.show');
        
        Route::post('event_offers/store', [EventOfferController::class,'store'])->name('event_offers.store');
        
        Route::get('event_offers/{id}/edit', [EventOfferController::class,'edit'])->name('event_offers.edit');
        
        Route::patch('event_offers/{id}', [EventOfferController::class,'update'])->name('event_offers.update');
        
        Route::post('get_event_offers', [EventOfferController::class,'getEventOffers'])->name('get_event_offers');
        
    //Event jobs routes
        
        Route::get('events/{id}/jobs', [EventController::class,'eventJobs'])->name('events.jobs');
        
        Route::post('/change_job_status', [EventController::class,'changeJobStatus'])->name('change_job_status');
        
    // Invoices routes    
        
        Route::get('invoices', [InvoiceController::class,'index'])->name('invoices.index');
        
        Route::get('invoices/create', [InvoiceController::class,'create'])->name('invoices.create');
        
        Route::get('invoices/{event_offer_id}/create', [InvoiceController::class,'createOfferInvoice'])->name('invoices.event_offer.create');
         
        Route::get('invoices/{id}', [InvoiceController::class,'show'])->name('invoices.show');
        
        Route::get('invoices/{id}/print', [InvoiceController::class,'printInvoice'])->name('invoices.print');
        
        Route::post('invoices/store', [InvoiceController::class,'store'])->name('invoices.store');
        
        Route::get('invoices/{id}/edit', [InvoiceController::class,'edit'])->name('invoices.edit');
        
        Route::patch('invoices/{id}', [InvoiceController::class,'update'])->name('invoices.update');
        
        Route::post('get_invoices', [InvoiceController::class,'getInvoices'])->name('get_invoices');
        
        Route::post('delete_invoice', [InvoiceController::class,'destroy'])->name('delete_invoice');
        
        Route::post('set_invoice_paid_amount', [InvoiceController::class,'setInvoicePaidAmount'])->name('set_invoice_paid_amount');
        
    // Prices routes    
        
        Route::get('prices', [PriceController::class,'index'])->name('prices.index');
        
        Route::patch('prices/update', [PriceController::class,'update'])->name('prices.update');
        
    
        
    });
    
    // Region routes
        
        Route::post('get_region_cities', [CityController::class,'getRegionCities'])->name('get_region_cities');
        
        Route::post('get_autocomplete_cities', [CityController::class,'getAutocompleteCities'])->name('get_autocomplete_cities');

require __DIR__.'/auth.php';
