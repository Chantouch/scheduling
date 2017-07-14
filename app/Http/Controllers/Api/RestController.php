<?php

namespace App\Http\Controllers\Api;

use App\Model\Meeting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RestController extends Controller
{
    function __construct()
    {
        $this->middleware('web');
    }

    public function getMeetingData()
    {
        $current_date = Carbon::now();
        $meetings = Meeting::with('user')
            ->where('date', '>=', $current_date->toDateString())
            //->orhere('start_time', '>=', $current_date->addHour(-1)->toTimeString())
            //->where('end_time', '>=', $current_date->toTimeString())
            ->get();
        return response()->json($meetings);
    }
}
