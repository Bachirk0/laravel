<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;

//Product Routes
Route::any('add', 'ProductController@add');
Route::any('update', 'ProductController@update');
Route::any('delete', 'ProductController@delete');
Route::any('show', 'ProductController@show');

//User Routes

Route::any('register', 'UserController@register');
Route::any('login', 'UserController@login');
