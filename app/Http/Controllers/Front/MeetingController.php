<?php

namespace App\Http\Controllers\Front;

use App\Model\Meeting;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $current_date = Carbon::now();
            $check_meeting = $current_date->format('H:i');
            $meetings = Meeting::with('user')
                ->where('meeting_date', '>=', $current_date->toDateString())
                ->orderBy('meeting_date', 'ASC')
                ->orderBy('start_time', 'ASC')
                ->get();
            if ($request->ajax()) {
                $view = view('html.meetings.table', compact('meetings', 'check_meeting'))->render();
                return response()->json(['html' => $view]);
            }
            return view('html.meetings.index', compact('meetings', 'check_meeting'));
        } catch (ModelNotFoundException $exception) {
            return redirect()->route('/')->with('error', 'There is something wrong with your request.');
        }
    }

}
