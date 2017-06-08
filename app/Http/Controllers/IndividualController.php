<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;

class IndividualController extends Controller
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
        $notice = \DB::table('notice')->where('addressee_id',Session::get('id'))->get();
        $user = \DB::table('user')->where('id',Session::get('id'))->get();
        if($user[0]->user_type == '보호사'){
            $etc = DB::table('resume')
                ->join('user', 'resume.sitter_id', '=', 'user.id')
                ->join('license', function ($join) {
                    $join->on('resume.sitter_id', '=', 'license.sitter_id')->orOn('resume.lisence', '=', 'license.license_num');
                })
                ->select('user.*', 'resume.*','license.*')
                ->get();
        }else{
            $etc = DB::table('user')
                ->join('care', 'user.id', '=', 'care.sitter_id')
                ->join('target','care.target_num', '=', 'target.num')
                ->select('user.*', 'target.*')
                ->get();
        }
        return view('individual.individual')->with('user', $user)->with('etc',$etc)->with('notice',$notice);
    }

    public function create()
    {
        $notice = \DB::table('notice')->where('addressee_id',Session::get('id'))->get();
        $user = \DB::table('user')->where('id', 'user1')->get();
        if($user[0]->user_type == '보호사'){
            $etc = DB::table('resume')
                ->join('user', 'resume.sitter_id', '=', 'user.id')
                ->join('license', 'resume.sitter_id', '=', 'license.sitter_id')
                ->select('user.*', 'resume.*','license.*')
                ->get();
        }else{
            $etc = DB::table('user')
                ->join('target', 'user.id', '=', 'target.user_id')
                ->select('user.*', 'target.*')
                ->get();
        }
        return view('individual.individualForm')->with('user', $user)->with('etc',$etc)->with('notice',$notice);
    }

    public function update(Request $request,$id){
/*
        $notice = \DB::table('notice')->get();
        $etc = DB::table('user')->findOrFail($id);

        $etc->update([
            'name' => $request->get('name'),
            'id' => $request->get('id'),
            'pw' => $request->get('pw'),
            'age' => $request->get('age'),
            'gender' => $request->get('gender'),
            'telephone' => $request->get('phone'),
            'cellphone' => $request->get('cellphone'),
            'email' => $request->get('email'),


        ]);*/
    }
}
