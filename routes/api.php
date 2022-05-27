<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
define("PAGINATION_COUNT", 10);
Route::group(['namespace'=>'App\Http\Controllers'], function(){
    ############## start gallary ###############
    Route::post('savegallary', 'GallaryController@store');
    Route::get('getallgallary', 'GallaryController@getAllGallary');
    Route::post('removegallary/{id}', 'GallaryController@destroy');
    ##############end gallary##################
    #################start video ##############
    Route::post('savevideo', 'VideoContoller@store');
    ################### end video #############
    #################start founder ##############
    Route::post('createfounder', 'FounderController@store');
    Route::get('getallfounder', 'FounderController@getAllFounder');
    Route::post('removefounder/{id}', 'FounderController@destroy');
    ################### end founder #############
    #################start Governorate ##############
    Route::post('creategovernorate', 'GovernorateController@store');
    Route::get('getallgovernorate', 'GovernorateController@getAll');
    Route::post('removegovernorate/{id}', 'GovernorateController@destroy');
    ################### end Governorate #############
            ##################### neeeeeews ###################
    Route::group(['namespace' => 'News'], function(){
        #################start news ##############
        Route::post('createnews', 'NewsController@store');
        Route::post('changestatusnews/{id}', 'NewsController@changeStatus');
        Route::post('changeconstnews/{id}', 'NewsController@changeConst');
        Route::get('getallnews', 'NewsController@getAllNews');
        Route::get('getallnewsconst', 'NewsController@getAllNewsConst');
        Route::post('removenews/{id}', 'NewsController@destroy');
        ################### end news #############
        #################start words ##############
        Route::post('createwords', 'WordsController@store');
        Route::get('getallwords/{id}', 'WordsController@getAll');
        Route::post('removewords/{id}', 'WordsController@destroy');
        ################### end words #############
        #################start source ##############
        Route::post('createsource', 'SourceController@store');
        Route::get('getallsources/{id}', 'SourceController@getAll');
        Route::post('removesource/{id}', 'SourceController@destroy');
        ################### end source #############
        #################start newsimages ##############
        Route::post('createnewsimages', 'NewsimagesController@store');
        Route::get('getallnewsimages/{id}', 'NewsimagesController@getAll');
        Route::post('removenewsimages/{id}', 'NewsimagesController@destroy');
        ################### end newsimages #############
    });

    
});

