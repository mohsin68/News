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
    ##################### start rejester and login and out ##############
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
    Route::post('logout', 'AuthController@logout');
    Route::get('user-profile', 'AuthController@userProfile'); 
    ##################### end rejester and login and out ##############
        Route::group(['middleware' => 'auth:api'], function(){
        ############## start gallary ###############
        Route::post('savegallary', 'GallaryController@store');
        Route::post('removegallary/{id}', 'GallaryController@destroy');
        ##############end gallary##################
        #################start video ##############
        Route::post('savevideo', 'VideoContoller@store');
        Route::post('removevideo/{id}', 'VideoContoller@destroy');
        ################### end video #############
        #################start founder ##############
        Route::post('createfounder', 'FounderController@store');
        Route::post('removefounder/{id}', 'FounderController@destroy');
        ################### end founder #############
        #################start Governorate ##############
        Route::post('creategovernorate', 'GovernorateController@store');
        Route::post('removegovernorate/{id}', 'GovernorateController@destroy');
        ################### end Governorate #############
        });
    ############## start gallary ###############
    Route::get('getallgallary', 'GallaryController@getAllGallary');
    ##############end gallary##################
    #################start video ##############
    Route::get('getallvideos', 'VideoContoller@getAllVideos');
    ################### end video #############
    #################start founder ##############
    Route::get('getallfounder', 'FounderController@getAllFounder');
    ################### end founder #############
    #################start Governorate ##############
    Route::get('getallgovernorate', 'GovernorateController@getAll');
    ################### end Governorate #############
    ##################### neeeeeews ###################
    Route::group(['namespace' => 'News'], function(){
        Route::group(['middleware' => 'auth:api'], function(){
            #################start news ##############
            Route::post('createnews', 'NewsController@store');
            Route::post('updatenews/{id}', 'NewsController@update');
            Route::post('changestatusnews/{id}', 'NewsController@changeStatus');
            Route::post('changeconstnews/{id}', 'NewsController@changeConst');
            Route::get('getallnews', 'NewsController@getAllNews');
            Route::get('getallnewsconst', 'NewsController@getAllNewsConst');
            Route::post('removenews/{id}', 'NewsController@destroy');
            ################### end news #############
            #################start words ##############
            Route::post('removewords/{id}', 'WordsController@destroy');
            ################### end words #############
            #################start source ##############
            Route::post('removesource/{id}', 'SourceController@destroy');
            ################### end source #############
            #################start newsimages ##############
            Route::post('createnewsimages', 'NewsimagesController@store');
            Route::post('removenewsimages/{id}', 'NewsimagesController@destroy');
            ################### end newsimages #############
            ################### start Idimages###############
            Route::post('createidimages', 'IdimageController@store');
            ################### start Idimages###############
        });
        #################start news ##############
        Route::get('getallnews', 'NewsController@getAllNews');
        Route::get('getallnewsconst', 'NewsController@getAllNewsConst');
        ################### end news #############
        #################start words ##############
        Route::get('getallwords/{id}', 'WordsController@getAll');
        ################### end words #############
        #################start source ##############
        Route::get('getallsources/{id}', 'SourceController@getAll');
        ################### end source #############
        #################start newsImages ##############
        Route::get('getAllNewsImages/{id}', 'NewsimagesController@getAll');
        ################### end newsImages #############
        

    });

    
});

