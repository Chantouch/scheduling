<?php

namespace App\Http\Controllers\Front;

use App\Model\Meeting;
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
        $meetings = Meeting::all();
        return view('html.meetings.index', compact('meetings'));
    }
}
