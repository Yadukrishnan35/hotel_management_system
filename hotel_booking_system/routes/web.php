<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'App\Http\Controllers\homeController@index');
Route::get('/add-country', 'App\Http\Controllers\adminController@addCountryForm')->name('add_country');
Route::get('/add-city','App\Http\Controllers\adminController@addCity')->name('add_city');
Route::get('/admin', 'App\Http\Controllers\adminController@adminPage');
Route::get('/view-city', 'App\Http\Controllers\adminController@cityView')->name('city_table');
Route::get('/get-city','App\Http\Controllers\adminController@searchByCountry');
Route::get('/get-countries','App\Http\Controllers\adminController@getCountries');


Route::post('/save_country','App\Http\Controllers\adminController@saveCountry')->name('save_country'); 
Route::post('/save-city','App\Http\Controllers\adminController@save_city')->name('save_city');
Route::post('/save-hotel-data','App\Http\Controllers\hotelController@save_hotel_data');
Route::get('/edit-city/{city_id}','App\Http\controllers\adminController@editCity')->name('edit-city');
Route::get('/delete-city/{city_id}','App\Http\Controllers\adminController@deleteCity')->name('delete-city');

Route::get('/add-hotel','App\Http\Controllers\hotelController@addHotelForm')->name('add_hotel');
Route::get('/view-hotel','App\Http\Controllers\hotelController@viewHotel')->name('view_hotel');
Route::get('/get-hotel-data','App\Http\Controllers\hotelController@get_hotel_data');
Route::post('/update-hotel','App\Http\Controllers\hotelController@updateHotel');
Route::post('/delete-hotel','App\Http\Controllers\hotelController@delete_hotel');
Route::get('/search-hotel','App\Http\Controllers\hotelController@search_hotel');
Route::get('/search-by-city','App\Http\Controllers\hotelController@searchByCity');
Route::get('/get-country','App\Http\Controllers\hotelController@get_countries');
Route::get('/get-hotel-datatable','App\Http\Controllers\hotelController@gethoteldetails');

// Route::prefix('room-types')->group(function() {
//     Route::get('add-room-type','App\Http\Controllers\hotelController@addRoomType')->name('add_room_type');
//     Route::post('/save-room-type','App\Http\Controllers\hotelController@save_room_type');

// });

Route::get('/add-room-type','App\Http\Controllers\roomController@index')->name('add_room_type');
Route::post('/save-room-type','App\Http\Controllers\roomController@saveRoomType');
Route::get('/get-room-type','App\Http\Controllers\roomController@get_room_type')->name('get_room_type');