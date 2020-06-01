<?php

Route::get('/group1', function () {
    return 'Group #1 Page';
})->middleware('whitelist:group1');

Route::get('/group2', function () {
    return 'Group #2 Page';
})->middleware('whitelist:group2');