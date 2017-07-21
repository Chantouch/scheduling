<?php

namespace App\Http\Controllers\Front;

use App\Model\Meeting;
use App\Model\Mission;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Vinkla\Hashids\HashidsManager;

class MissionController extends Controller
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
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $date = Carbon::now();
        $missions = Mission::with('user')
            //->where('start_date', '>=', $date->format('Y-m-d'))
            ->where('end_date', '>=', $date->format('Y-m-d'))
            ->orderBy('start_date', 'ASC')
            ->get();
        if ($request->ajax()) {
            $view = view('html.missions.table', compact('missions'))->render();
            return response()->json(['html' => $view]);
        }
        return view('html.missions.index', compact('missions'));
    }
}
