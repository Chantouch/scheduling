<?php

namespace App\Http\Controllers\Front;

use App\Model\Meeting;
use App\Model\Mission;
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $missions = Mission::all();
        return view('html.missions.index', compact('missions'));
    }
}
