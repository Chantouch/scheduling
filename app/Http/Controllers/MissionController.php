<?php

namespace App\Http\Controllers;

use App\Model\Mission;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;
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
        $missions = Mission::with('user')
            ->orderBy('start_date', 'ASC')
            ->orderBy('end_date', 'ASC')
            ->get();
        return view('missions.index', compact('missions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('missions.create');
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
            $validator = Validator::make($data, Mission::rules(), Mission::messages());
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $data['start_date'] = date('Y-m-d', strtotime($request->start_date));
            $data['end_date'] = date('Y-m-d', strtotime($request->end_date));
            $data['user_id'] = $this->guard()->id;
            $mission = Mission::create($data);
            if (!$mission) {
                DB::rollBack();
                return response()->json('Can not add new record');
            }
            DB::commit();
            $dataRedis = [
                'event' => 'create-mission',
                'data' => [
                    'mission_data' => $mission,
                ]
            ];
            Redis::publish('create-mission-channel', json_encode($dataRedis));
            return redirect()->route('app.missions.index')->with('success', 'បេសកកម្មបានបន្ថែមដោយជោគជ័យ។');
        } catch (ModelNotFoundException $exception) {
            DB::rollBack();
            return response()->json('Can not add new record');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Mission|\Illuminate\Database\Eloquent\Builder
     */
    public function show($id)
    {
        $decoded = $this->hashid->decode($id);
        $id = @$decoded[0];
        if ($id === null) {
            return response()->json(['error' => 'Can not find this id']);
        }
        $mission = Mission::with('user')->find($id);
        return $mission;
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
        $mission = Mission::with('user')->find($id);
        return view('missions.edit', compact('mission'));
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
            $mission = Mission::with('user')->find($id);
            $validator = Validator::make($data, Mission::rules(), Mission::messages());
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $data['start_date'] = date('Y-m-d', strtotime($request->start_date));
            $data['end_date'] = date('Y-m-d', strtotime($request->end_date));
            $update = $mission->update($data);
            if (!$update) {
                DB::rollBack();
                return response()->json('Can not add update record');
            }
            DB::commit();
            $dataRedis = [
                'event' => 'update-mission',
                'data' => [
                    'mission_data' => $mission,
                ]
            ];
            Redis::publish('update-mission-channel', json_encode($dataRedis));
            return redirect()->route('app.missions.index')->with('success', 'បេសកកម្មបានកែប្រែដោយជោគជ័យ។');
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
        $mission = Mission::with('user')->find($id);
        $delete = $mission->delete();
        if (!$delete) {
            DB::rollBack();
            return response()->json('Can not delete mission');
        }
        $dataRedis = [
            'event' => 'delete-mission',
            'data' => [
                'mission_data' => $mission,
            ]
        ];
        Redis::publish('delete-mission-channel', json_encode($dataRedis));
        return response()->json('បេសកកម្មបានលុបដោយជោគជ័យ។');
    }


    public function guard()
    {
        return auth()->user();
    }
}
