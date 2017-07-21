<?php

namespace App\Http\Controllers;

use App\Model\Meeting;
use App\Model\Mission;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fromDateStartOfWeek = Carbon::now()->subDay()->startOfWeek()->toDateString(); // or ->format(..)
        $fromDateStartOfMonth = Carbon::now()->subDay()->startOfMonth()->toDateString(); // or ->format(..)
        $fromDateStartLastWeek = Carbon::now()->subWeek()->startOfWeek()->toDateString();
        $tillDateLastWeek = Carbon::now()->subWeek()->endOfWeek()->toDateString();
        $tillDateOfWeek = Carbon::now()->subDay()->toDateString();
        $tillDateOfMonth = Carbon::now()->subDay()->endOfMonth()->toDateString();
        $this_week_meetings = Meeting::whereBetween(DB::raw('date(meeting_date)'), [$fromDateStartOfWeek, $tillDateOfWeek])->count();
        $this_month_meetings = Meeting::whereBetween(DB::raw('date(meeting_date)'), [$fromDateStartOfMonth, $tillDateOfMonth])->count();
        $last_week_meetings = Meeting::whereBetween(DB::raw('date(meeting_date)'), [$fromDateStartLastWeek, $tillDateLastWeek])->count();
        $this_week_missions = Mission::whereBetween(DB::raw('date(start_date)'), [$fromDateStartOfWeek, $tillDateOfWeek])->count();
        $this_month_missions = Mission::whereBetween(DB::raw('date(start_date)'), [$fromDateStartOfMonth, $tillDateOfMonth])->count();
        $last_week_missions = Mission::whereBetween(DB::raw('date(start_date)'), [$fromDateStartLastWeek, $tillDateLastWeek])->count();
        $meetings = Meeting::all();
        $missions = Mission::all();
        return view('home',
            compact(
                'this_week_meetings', 'this_month_meetings', 'meetings', 'missions', 'last_week_meetings',
                'this_month_missions', 'this_week_missions', 'last_week_missions'
            )
        );
    }
}
