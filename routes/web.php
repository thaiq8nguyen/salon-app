<?php

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

use Illuminate\Support\Facades\Mail;

Route::get('/', 'AppController@index');

/*TESTING MAIL SERVICES*/
/*
Route::get('/send-test-email', function () {

    Mail::raw('testing sending email from laravel', function ($message) {
        $message->from('');
        $message->to('');
        $message->subject('Test Laravel Email');
    });

    return response()->json('Sent');
});
*/

/* TESTING MAIL RENDERING*/

Route::get('/view-test-email', function () {
    $date = '2019-04-06';
    $technicianSales = App\Technician::with(['sale' => function ($query) use ($date) {
        $query->where('date', $date);
    }])->whereHas('sale', function ($query) use ($date) {
        $query->where('date', $date);
    })->orderBy('first_name', 'asc')->get();

    $results = $technicianSales->makeHidden(['phone', 'email', 'technician_image']);

    return new App\Mail\TechnicianSalesAddedMail($results);
});
