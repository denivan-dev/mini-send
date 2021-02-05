<?php

use Illuminate\Support\Facades\Route;

Route::apiResources([
    'emails' => 'API\MailController',
    'activities' => 'API\ActivitiesController',
]);
