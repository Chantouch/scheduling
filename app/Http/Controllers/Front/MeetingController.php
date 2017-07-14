<?php

namespace App\Http\Controllers\Front;

use App\Model\Meeting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Vinkla\Hashids\HashidsManager;

class MeetingController extends Controller
{
    public $hashid;

    /**
     * MeetingController constructor.
     * @param HashidsManager $hashid
     */
    public function __construct(HashidsManager $hashid)
    {
        $this->middleware('web');
        $this->hashid = $hashid;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $current_date = Carbon::now();
        $meetings = Meeting::with('user')
            ->where('date', '>=', $current_date->toDateString())
            //->orhere('start_time', '>=', $current_date->addHour(-1)->toTimeString())
            //->where('end_time', '>=', $current_date->toTimeString())
            ->get();
        return view('html.meetings.index', compact('meetings'));
    }
}
