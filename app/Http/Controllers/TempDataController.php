<?php

namespace App\Http\Controllers;

use App\Model\Meeting;
use App\Model\TempData;
use Carbon\Carbon;
use Google_Service_Calendar;
use Google_Service_Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TempDataController extends BaseController
{

    /**
     * TempDataController constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function syncGoogleCalendars()
    {
        try {
            $service = new Google_Service_Calendar($this->client);
            $calendarId = 'dg.gdnt@gmail.com';
            $optParams = array(
                //'maxResults' => 50,
                'orderBy' => 'startTime',
                'singleEvents' => TRUE,
                //'timeMin' => date('c'),
            );
            $results = $service->events->listEvents($calendarId, $optParams);
            $calendars = $results->getItems();
            $temp_data = TempData::with('user')->pluck('created')->toArray();
            $added = false;
            $inserts = [];
            foreach ($calendars as $calendar) {
                if (in_array($summary = $calendar['created'], $temp_data)) {
                    $data_temp = TempData::with('user')->where('created', $summary)->first();
                    if (is_null($data_temp)) {
                        continue;
                    }
                    $update_date = [
                        'data' => $calendar['summary'],
                        'created' => $calendar['created'],
                        'updated' => $calendar['updated'],
                    ];
                    $added = $data_temp->update($update_date);
                    continue;
                }
                $inserts[] = [
                    'data' => $calendar['summary'],
                    'created' => $calendar['created'],
                    'created_at' => Carbon::now(),
                    'updated' => $calendar['updated'],
                    'updated_at' => Carbon::now(),
                ];
                $temp_data[] = $calendar['created'];
            }
            if (!empty($inserts)) {
                $insert_success = TempData::with('user')->insert($inserts);
                if (!$insert_success) {
                    return redirect()->back()->with('error', 'Unable to process your request right now, Please contact to System admin @070375783');
                }
                return redirect()->back()->with('success', 'Data inserted/updated successfully.');
            }
            if ($added) {
                return response()->json(['status' => 'Success']);
            } else {
                return response()->json(['status' => 'Data added, but it is already exist']);
            }
            //return view('app.calendar.index', compact('calendars'));
        } catch (Google_Service_Exception $exception) {
            return response()->json(['Error' => 'មានបញ្ហាបច្ចេកទេស ក្នុងការទាញយកទិន្នន័យពី Google Calendar']);
        }
    }


    /**
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function syncGoogleCalendarsToLocal()
    {
        try {
            $service = new Google_Service_Calendar($this->client);
            $calendarId = 'dg.gdnt@gmail.com';
            $optParams = array(
                //'maxResults' => 50,
                'orderBy' => 'startTime',
                'singleEvents' => TRUE,
                //'timeMin' => date('c'),
            );
            $results = $service->events->listEvents($calendarId, $optParams);
            $calendars = $results->getItems();
            $temp_data = Meeting::with('user')->pluck('subject')->toArray();
            $added = false;
            $inserts = [];
            foreach ($calendars as $calendar) {
                $summary = $calendar['summary'];
                if (strpos($summary, 'ប្រជុំ') !== false) {
                    if (in_array($summary, $temp_data)) {
                        $data_temp = Meeting::with('user')->where('subject', $summary)->first();
                        if (is_null($data_temp)) {
                            continue;
                        }
                        $update_date = [
                            'subject' => $calendar['summary'],
                            'start_time' => $calendar['start']['dateTime'],
                            'end_time' => $calendar['end']['dateTime'],
                        ];
                        $added = $data_temp->update($update_date);
                        continue;
                    }
                    $inserts[] = [
                        'subject' => $calendar['summary'],
                        'created' => $calendar['created'],
                        'created_at' => Carbon::now(),
                        'updated' => $calendar['updated'],
                        'updated_at' => Carbon::now(),
                    ];
                    $temp_data[] = $calendar['summary'];
                }
            }
            if (!empty($inserts)) {
                $insert_success = Meeting::with('user')->insert($inserts);
                if (!$insert_success) {
                    return redirect()->back()->with('error', 'Unable to process your request right now, Please contact to System admin @070375783');
                }
                return redirect()->back()->with('success', 'Data inserted/updated successfully.');
            }
            if ($added) {
                return response()->json(['status' => 'Success']);
            } else {
                return response()->json(['status' => 'Data added, but it is already exist']);
            }
            //return view('app.calendar.index', compact('calendars'));
        } catch (Google_Service_Exception $exception) {
            return response()->json(['Error' => 'មានបញ្ហាបច្ចេកទេស ក្នុងការទាញយកទិន្នន័យពី Google Calendar']);
        }
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Http\JsonResponse
     */
    public function syncMeetingLocalData()
    {
        try {
            $query = 'ប្រជុំ';
            $local_temp_data = TempData::with('user')
                ->where('data', 'like', '%' . $query . '%')
                ->paginate(50);
            return $local_temp_data;
        } catch (ModelNotFoundException $exception) {
            return response()->json(['Status' => 'Can not retrieve data from local']);
        }
    }

    public function syncMissionLocalData()
    {
        try {
            $query = 'បេសកកម្ម';
            $local_temp_data = TempData::with('user')
                ->where('data', 'like', '%' . $query . '%')
                ->paginate(50);
            return $local_temp_data;
        } catch (ModelNotFoundException $exception) {
            return response()->json(['Status' => 'Can not retrieve data from local']);
        }
    }
}
