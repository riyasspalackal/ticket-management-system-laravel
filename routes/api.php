<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventRegistrationController;
use App\Http\Controllers\TicketController;




/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', [AuthController::class, 'login']);

Route::group([
    'middleware' => 'jwt.verify',
    'prefix' => 'auth'

], function ($router) {
    Route::post('/register', [EventRegistrationController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
    Route::get('/get-all-event', [EventRegistrationController::class, 'getAllEvent']);  
    Route::get('/get-event-by-id/{id}', [EventRegistrationController::class, 'getEventById']);    
    Route::get('/get-event-with-lineup/{id}', [EventRegistrationController::class, 'getEventByIdWithLineUps']);
    Route::get('/get-lineup-by-event-id/{id}', [EventRegistrationController::class, 'getLineUpByEventId']);    
    Route::get('/delete-event/{id}', [EventRegistrationController::class, 'deleteEvent']);    
    Route::post('/update-event/{id}', [EventRegistrationController::class, 'updateEvent']); 
    Route::get('/get-ticket-details/{id}', [TicketController::class, 'getTicketDetails']);  
    Route::post('/ticket-booking', [TicketController::class, 'ticketBooking']);
    Route::get('/get-all-booked-ticket', [TicketController::class, 'getAllBookedTicket']);  




});