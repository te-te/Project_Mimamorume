<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class LogSpecController extends Controller
{
    public function __construct()
    {
        $this->middleware('web');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Session::get('id')){
            $notice = \DB::table('notice')
                ->join('user', 'notice.sender', '=', 'user.id')
                ->where('notice.addressee_id',Session::get('id'))
                ->get();

            $user_type = \DB::table('user')->where('id',Session::get('id'))->get();

            if($user_type[0]->user_type == '보호사'){
                $log_id = \DB::table('care')->where('sitter_id',Session::get('id'))->get();

                if($log_id == '[]'){
                    $log = '[]';
                    $target_list = '없음';
                    $activi = '없음';
                }else{
                    $log = \DB::table('work_log')
                        ->join('work_content', 'work_log.num', '=', 'work_content.log_num')
                        ->where('work_log.sitter_id','=',Session::get('id'))
                        ->where('work_log.target_num','=',$log_id[0]->target_num)
                        ->select('work_log.*', 'work_content.*')
                        ->get();

                    $target_list = \DB::table('care')
                        ->join('target','care.target_num','=','target.num')
                        ->where('sitter_id',Session::get('id'))
                        ->get();
                    $activi = $target_list[0]->num;
                }

            }else if($user_type[0]->user_type == '보호자'){
                $log_id = \DB::table('contract')->where('family_id',Session::get('id'))->get();
                $user_target = \DB::table('support')
                    ->join('user','support.family_id','=','user.id')
                    ->join('target','support.target_num','=','target.num')
                    ->where('user.id',Session::get('id'))
                    ->get();

                if($log_id == '[]'){
                    $log = '[]';
                    $target_list = $user_target;
                    $activi = $user_target[0]->num;
                }else{
                    $log = \DB::table('work_log')
                        ->join('work_content', 'work_log.num', '=', 'work_content.log_num')
                       // ->where('work_log.sitter_id','=',$log_id[0]->sitter_id)
                        ->where(function ($query) use($log_id){
                            for($i = 0; $i < count($log_id) ; $i++)
                                $query->where('work_log.sitter_id',$log_id[$i]->sitter_id);
                        })
                        ->where('work_log.target_num','=',$user_target[0]->target_num)
                        ->select('work_log.*', 'work_content.*')
                        ->get();

                    $target_list = \DB::table('support')
                        ->join('user','support.family_id','=','user.id')
                        ->join('target','support.target_num','target.num')
                        ->where('family_id',Session::get('id'))
                        ->get();
                    $activi = $user_target[0]->num;
                }
            }

            return view('task.logSpec')->with('log',$log)->with('user',$user_type)->with('target',$target_list)->with('num',$activi)->with('notice',$notice);
        }else{
            $alert = '잘못된 접근입니다.';

            return redirect('/')->with('alert',$alert);
        }
    }

    public function show($num){
        $notice = \DB::table('notice')
            ->join('user', 'notice.sender', '=', 'user.id')
            ->where('notice.addressee_id',Session::get('id'))
            ->get();


        $etc = \DB::table('work_log')
            ->join('work_content', 'work_log.num', '=', 'work_content.log_num')
            ->join('medicine_schedule', 'work_log.num', '=', 'medicine_schedule.log_num')
            ->where('work_log.num',$num)
            ->select('work_log.*', 'work_content.*','medicine_schedule.*')
            ->get();

        $target_no = \DB::table('work_log')->where('num',$num)->get();
        $target = \DB::table('target')->where('num',$target_no[0]->target_num)->get();

        return view('task.logSpecView')->with('log',$etc)->with('target',$target)->with('notice',$notice);
    }

    public function store(Request $request){
        $notice = \DB::table('notice')
            ->join('user', 'notice.sender', '=', 'user.id')
            ->where('notice.addressee_id',Session::get('id'))
            ->get();

        \DB::table('work_log')->insert([
            'num' => null,
            'sitter_id'=>Session::get('id'),
            'target_num'=>$request->get('target_name'),
            'work_date'=> $request->get('date'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        $work_log = \DB::table('work_log')->get();
        $count = count($work_log);
        $work_log_num = $work_log[$count-1]->num;

        \DB::table('work_content')->insert([
            'num'=>null,
            'log_num'=>$work_log_num,
            'content_type'=>$request->get('content_type'),
            'content'=>$request->get('content'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        $time = explode(' ',$request->get('dateEnd'));

        \DB::table('medicine_schedule')->insert([
            'num' => null,
            'log_num' => $work_log_num,
            'medicine_name' => $request->get('medicine_name'),
            'start_date' => $request->get('dateStart'),
            'end_date' => $request->get('dateEnd'),
            'time' => $time[1],
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        $log_id = \DB::table('care')->where('sitter_id',Session::get('id'))->get();

        if($log_id == '[]'){
            $log = '[]';
            $target_list = '없음';
            $activi = '없음';
        }else{
            $log = \DB::table('work_log')
                ->join('work_content', 'work_log.num', '=', 'work_content.log_num')
                ->where('work_log.sitter_id','=',$log_id[0]->sitter_id)
                ->where('work_log.target_num','=',$log_id[0]->target_num)
                ->select('work_log.*', 'work_content.*')
                ->get();

            $target_list = \DB::table('care')
                ->join('target','care.target_num','=','target.num')
                ->where('sitter_id',Session::get('id'))
                ->get();
            $activi = $target_list[0]->num;
        }


        $user_type = \DB::table('user')->where('id',Session::get('id'))->get();

        return redirect('/logSpec')->with('log',$log)->with('target',$target_list)->with('num',$activi)->with('user',$user_type)->with('notice',$notice);
    }

    public function logSpecTarget($num){
        $notice = \DB::table('notice')
            ->join('user', 'notice.sender', '=', 'user.id')
            ->where('notice.addressee_id',Session::get('id'))
            ->get();

        $user_type = \DB::table('user')->where('id',Session::get('id'))->get();

        $sitter = \DB::table('care')
            ->join('user','care.sitter_id','=','user.id')
            ->join('target','care.target_num','=','target.num')
            ->where('care.target_num',$num)
            ->get();

        if($sitter == '[]'){
            $stter_id = null;
        }else{
            $stter_id = $sitter[0]->sitter_id;
        }

        $log = \DB::table('work_log')
            ->join('work_content', 'work_log.num', '=', 'work_content.log_num')
            ->where('work_log.sitter_id','=',$stter_id)
            ->where('work_log.target_num','=',$num)
            ->select('work_log.*', 'work_content.*')
            ->get();

        if($user_type[0]->user_type == '보호사'){
            $target_list = \DB::table('care')
                ->join('target','care.target_num','=','target.num')
                ->where('sitter_id',Session::get('id'))
                ->get();
        }else{
            $target_list = \DB::table('support')
                ->join('target','support.target_num','=','target.num')
                ->where('family_id',Session::get('id'))
                ->get();
        }
        $activi = $num;

        return view('task.logSpec')->with('log',$log)->with('target',$target_list)->with('num',$activi)->with('user',$user_type)->with('notice',$notice);
    }
}
