<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SnapShotController extends Controller
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
        return view('monitor.snapshot');
    }
}