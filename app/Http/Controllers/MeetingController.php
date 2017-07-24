<?php

namespace App\Http\Controllers;

use App\Model\Meeting;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;
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
        $this->middleware('auth');
        $this->hashid = $hashid;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $meetings = Meeting::with('user')
                ->orderBy('meeting_date', 'ASC')
                ->orderBy('start_time', 'ASC')
                ->get();
            return view('meetings.index', compact('meetings'));
        } catch (ModelNotFoundException $exception) {
            return response()->json('Error on getting data');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('meetings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->all();
            $validator = Validator::make($data, Meeting::rules(), Meeting::messages());
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $data['meeting_date'] = date('Y-m-d', strtotime($request->meeting_date));
            $data['time'] = date('H:i:s', strtotime($request->time));
            $data['user_id'] = $this->guard()->id;
            $data['ampm'] = substr(date('H:i:s A', strtotime($request->time)), -2);
            $meeting = Meeting::create($data);
            if (!$meeting) {
                DB::rollBack();
                return response()->json('Can not add new record');
            }
            DB::commit();
            $dataRedis = [
                'event' => 'create-meeting',
                'data' => [
                    'meeting_data' => $meeting,
                ]
            ];
            Redis::publish('create-meeting-channel', json_encode($dataRedis));
            return redirect()->route('app.meetings.index')->with('success', 'ប្រជុំបានបន្ថែមដោយជោគជ័យ។');
        } catch (ModelNotFoundException $exception) {
            DB::rollBack();
            return response()->json('Can not add new record');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Meeting|\Illuminate\Database\Eloquent\Builder
     */
    public function show($id)
    {
        $decoded = $this->hashid->decode($id);
        $id = @$decoded[0];
        if ($id === null) {
            return response()->json(['error' => 'Can not find this id']);
        }
        $meeting = Meeting::with('user')->find($id);
        return $meeting;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $decoded = $this->hashid->decode($id);
        $id = @$decoded[0];
        if ($id === null) {
            return response()->json(['error' => 'Can not find this id']);
        }
        $meeting = Meeting::with('user')->find($id);
        return view('meetings.edit', compact('meeting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $decoded = $this->hashid->decode($id);
            $id = @$decoded[0];
            if ($id === null) {
                return response()->json(['error' => 'Can not find this id']);
            }
            $data = $request->all();
            $meeting = Meeting::with('user')->find($id);
            $validator = Validator::make($data, Meeting::rules(), Meeting::messages());
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $data['meeting_date'] = date('Y-m-d', strtotime($request->meeting_date));
            $data['time'] = date('H:i:s', strtotime($request->time));
            $data['ampm'] = substr(date('H:i:s A', strtotime($request->time)), -2);
            $update = $meeting->update($data);
            if (!$update) {
                DB::rollBack();
                return response()->json('Can not add update record');
            }
            DB::commit();
            $dataRedis = [
                'event' => 'update-meeting',
                'data' => [
                    'meeting_data' => $meeting,
                ]
            ];
            Redis::publish('update-meeting-channel', json_encode($dataRedis));
            return redirect()->route('app.meetings.index')->with('message', 'ប្រជុំបានកែប្រែដោយជោគជ័យ។');
        } catch (ModelNotFoundException $exception) {
            DB::rollBack();
            return response()->json('Can not add update record');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $decoded = $this->hashid->decode($id);
        $id = @$decoded[0];
        if ($id === null) {
            return response()->json(['error' => 'Can not find this id']);
        }
        $meeting = Meeting::with('user')->find($id);
        $delete = $meeting->delete();
        $dataRedis = [
            'event' => 'delete-meeting',
            'data' => [
                'meeting_data' => $meeting,
            ]
        ];
        Redis::publish('delete-meeting-channel', json_encode($dataRedis));
        if (!$delete) {
            DB::rollBack();
            return response()->json('Can not delete meeting');
        }
        return response()->json('ប្រជុំបានលុបដោយជោគជ័យ។');
    }

    /**
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function guard()
    {
        return auth()->user();
    }
}
