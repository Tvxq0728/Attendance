<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StampController;
use App\Http\Controllers\AttendanceController;

Route::get('/', function () {
    $user = Auth::user();
    return view('index',["user" => $user]);
})
->middleware(['auth']);
Route::post('/',function() {
    [StampController::class,"create"];
})
->middleware(['auth']);
// 勤怠開始ボタンを押した時
Route::post('/stamp/start',
[StampController::class,"attendance_start"])
->middleware(['auth']);
// 勤怠終了ボタンを押した時
Route::post('/stamp/end',
[StampController::class,'attendance_end'])
->middleware(['auth']);

//  休憩用のコントローラを作成
// 休憩開始ボタンを押した時
Route::post('/rest/start',
[StampController::class,'rest_start'])
->middleware(['auth']);
// 休憩終了ボタンを押した時
Route::post('/rest/end',
[StampController::class,'rest_end'])
->middleware(['auth']);

// 日別勤怠管理
Route::get('/attendance',
[AttendanceController::class,'create'])
->middleware(['auth']);
Route::post('/attendance',
[AttendanceController::class,'search'])
->middleware(['auth']);









Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
