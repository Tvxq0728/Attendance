<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\Stamp;
use App\Models\Rest;
use Carbon\Carbon;

class StampController extends Controller
{
    public function index() {
        $user   = Auth::user();
        // ↓必要なのか
        $end_at = Stamp::where('user_id',$user->id)
        ->where('date',Carbon::now()->format('Y-m-d'))
        ->value('end_at');
        return view('index',["user" => $user]);
    }
    // 勤怠開始を記録する
    // 二重打刻ができないようにボタンを非活性にする。
    // 再リロードした場合 = 出勤している状態で出勤打刻を押した場合、メッセージを出力。
    public function attendance_start() {
        $start_time = Stamp::where('user_id',Auth::user()->id)
        ->where('date',Carbon::today()
        ->format('Y-m-d'))
        ->value('start_at');
        if ($start_time == null) {
            Stamp::create([
                'user_id'  => Auth::id(),
                'date'     => Carbon::now()->format('Y-m-d'),
                'start_at' => Carbon::now()->format('H:i:s'),
            ]);
            return redirect('/')->with([
                "message"  => "出勤記録しました",
                "start"    => "true",
                "rest_end" => "true"
            ]);
        }
        return redirect('/')->with([
            "message"   => "出勤済",
            "start"     => "true",
            "rest_end"  => "true",
        ]);
    }
    // 勤怠終了を記録すると同時に勤怠時間も計算。
    // 既に退勤している状態で退勤打刻を押した場合、
    // メッセージを出力
    // 勤怠時間は差分の秒数を計算後、時間/分/秒に切り分けて処理
    public function attendance_end() {
        $user = Auth::user();
        $today = Carbon::today()->format('Y-m-d');
        $end_time = Stamp::where('date',$today)
        ->value('end_at');
        if ($end_time !== null)
        {
            return redirect('/')
            ->with("message","退勤済または休憩中");
        }
        else if (!empty(Stamp::where('user_id',$user->id)
        ->where('date',$today)
        ->value('rest_id')))
        {
            $work_total = Stamp::where('user_id',$user->id)
            ->where('date',$today)
            ->orderBy('id','desc')
            ->value('start_at')
            ->diffINSeconds(Carbon::now()
            ->format('H:i:s'));
            // 出勤と退勤の差分を休憩時間で差し引き勤務時間を集計する。
            $work_hour  = floor($work_total / 3600);
            $work_min   = floor(($work_total - 3600 * $work_hour) / 60);
            $work_sec   = floor($work_total % 60);
            $work_hour  = $work_hour < 10 ? "0" .
            $work_hour : $work_hour;
            $work_min   = $work_min < 10 ? "0" .
            $work_min : $work_min;
            $work_sec   = $work_sec <10 ? "0" .
            $work_sec : $work_sec;
            $work_total = $work_hour . ":" . $work_min . ":" . $$work_sec;
            // 休憩時間を差し引いた勤務時間
            $attendance_total = Rest::where('stamp_id',Stamp::where('user_id',Auth::user()->id)
            ->latest()
            ->first()
            ->id)
            ->orderBy('created_at','desc')
            ->value('total_at')
            ->diffINSeconds($work_total);
        }
    }
}
