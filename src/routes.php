<?php

Route::group(['prefix' => 'api/audit'], function(){
    Route::get('activity_logs','Faacsilva\Audit\Controllers\ActivityLogController@index');
});