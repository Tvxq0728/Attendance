<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StampController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\UserListController;

Route::get('/', function () {
    $user = Auth::user();
    return view('index',["user" => $user]);
})
->middleware(["auth"])
->name(['login']);