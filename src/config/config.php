<?php

return [

    /*
    |--------------------------------------------------------------------------
    | User model
    |--------------------------------------------------------------------------
    |
    | We need know what is your model to retrieve associated user
    |
    */

    'user_model' => App\User::class,

    'label' => 'name',

    'foreign_key' => 'user_id',

];
