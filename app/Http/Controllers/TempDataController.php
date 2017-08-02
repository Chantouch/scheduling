<?php

namespace App\Http\Controllers;

use App\Model\JsonData;
use App\Model\Meeting;
use App\Model\Mission;
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
            $minDate = date('Y-m-d', strtotime('-1 days')) . "T00:00:00-04:00";
            $maxDate = date('Y-m-d', strtotime('+90 days')) . "T00:00:00-04:00";
            $optParams = array(
                //'maxResults' => 50,
                'orderBy' => 'startTime',
                'singleEvents' => TRUE,
                'timeMin' => $minDate,
                'timeMax' => $maxDate
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
            $minDate = date('Y-m-d', strtotime('-1 days')) . "T00:00:00-04:00";
            $maxDate = date('Y-m-d', strtotime('+90 days')) . "T00:00:00-04:00";
            $optParams = array(
                //'maxResults' => 50,
                'orderBy' => 'startTime',
                'singleEvents' => TRUE,
                'timeMin' => $minDate,
                'timeMax' => $maxDate
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
            $meetings = Meeting::with('user')->pluck('created')->toArray();
            $temp_data = JsonData::with('owner')
                ->where('summary', 'like', '%' . $query . '%')
                ->orWhere('summary', 'like', '%' . 'Meeting' . '%')
                ->orWhere('summary', 'like', '%' . 'Meetings' . '%')
                ->get();
            $inserts = [];
            foreach ($temp_data as $calendar) {
                $replace_start = trim(str_replace(['T', '+07:00'], ' ', $calendar->start));
                //dd(substr($replace_start, 0, -9));
                $replace_end = trim(str_replace(['T', '+07:00'], ' ', $calendar->end));
                if (in_array($created = $calendar['created'], $meetings)) {
                    $data_temp = Meeting::with('user')->where('created', $created)->first();
                    if (is_null($data_temp)) {
                        continue;
                    }
                    $update_array = [
                        'user_id' => 1,
                        'location' => $calendar->location,
                        'subject' => $calendar->summary,
                        'updated' => $calendar->updated,
                        'meeting_date' => substr($replace_start, 0, -9),
                        'start_time' => substr($replace_start, -8),
                        'end_time' => substr($replace_end, -8),
                        //'htmlLink' => $calendar->htmlLink,
                        'updated_at' => Carbon::now(),
                        'created' => $calendar->created,
                    ];
                    $data_temp->update($update_array);
                    continue;
                }
                $inserts[] = [
                    'user_id' => 1,
                    'location' => $calendar->location,
                    'subject' => $calendar->summary,
                    'updated' => $calendar->updated,
                    'meeting_date' => substr($replace_start, 0, -9),
                    'start_time' => substr($replace_start, -8),
                    'end_time' => substr($replace_end, -8),
                    //'htmlLink' => $calendar->htmlLink,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'created' => $calendar->created,
                ];
                $temp_data[] = $calendar['created'];
            }
            if (!empty($inserts)) {
                $insert_success = Meeting::with('user')->insert($inserts);
                if (!$insert_success) {
                    return response()->json(['status' => 'Unable to process your request right now, Please contact to System admin @070375783']);
                }
            }
            return response()->json(['status' => 'Success Data inserted/updated successfully.']);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['Status' => 'Can not retrieve data from local']);
        }
    }

    public function syncMissionLocalData()
    {
        try {
            $query = 'បេសកកម្ម';
            $meetings = Mission::with('user')->pluck('created')->toArray();
            $temp_data = JsonData::with('owner')
                ->where('summary', 'like', '%' . $query . '%')
                ->get();
            $inserts = [];
            foreach ($temp_data as $calendar) {
                $replace_start = trim(str_replace(['T', '+07:00'], ' ', $calendar->start));
                $replace_end = trim(str_replace(['T', '+07:00'], ' ', $calendar->end));
                if (in_array($created = $calendar['created'], $meetings)) {
                    $data_temp = Mission::with('user')->where('created', $created)->first();
                    if (is_null($data_temp)) {
                        continue;
                    }
                    $update_array = [
                        'user_id' => 1,
                        'location' => $calendar->location,
                        'mission' => $calendar->summary,
                        'updated' => $calendar->updated,
                        'start_date' => substr($replace_start, 0, -6),
                        'end_date' => substr($replace_end, 0, -6),
                        //'htmlLink' => $calendar->htmlLink,
                        'updated_at' => Carbon::now(),
                        'created' => $calendar->created,
                    ];
                    $data_temp->update($update_array);
                    continue;
                }
                $inserts[] = [
                    'user_id' => 1,
                    'location' => $calendar->location,
                    'mission' => $calendar->summary,
                    'updated' => $calendar->updated,
                    'start_date' => substr($replace_start, 0, -6),
                    'end_date' => substr($replace_end, 0, -6),
                    //'htmlLink' => $calendar->htmlLink,
                    'updated_at' => Carbon::now(),
                    'created_at' => Carbon::now(),
                    'created' => $calendar->created,
                ];
                $temp_data[] = $calendar['created'];
            }
            if (!empty($inserts)) {
                $insert_success = Mission::with('user')->insert($inserts);
                if (!$insert_success) {
                    return response()->json(['status' => 'Unable to process your request right now, Please contact to System admin @070375783']);
                }
            }
            return response()->json(['status' => 'Success Data inserted/updated successfully.']);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['Status' => 'Can not retrieve data from local']);
        }
    }

    public function testSync()
    {
        try {
            $service = new Google_Service_Calendar($this->client);
            $calendarId = 'dg.gdnt@gmail.com';
            $minDate = date('Y-m-d', strtotime('-1 days')) . "T00:00:00-04:00";
            $maxDate = date('Y-m-d', strtotime('+90 days')) . "T00:00:00-04:00";
            $optParams = array(
                //'maxResults' => 50,
                'orderBy' => 'startTime',
                'singleEvents' => TRUE,
                'timeMin' => $minDate,
                'timeMax' => $maxDate
            );
            $results = $service->events->listEvents($calendarId, $optParams);
            $calendars = $results->getItems();
            $temp_data = JsonData::with('owner')->pluck('created')->toArray();
            $updated = false;
            $inserts = [];
            foreach ($calendars as $calendar) {
                if (in_array($summary = $calendar['created'], $temp_data)) {
                    $data_temp = JsonData::with('owner')->where('created', $summary)->first();
                    if (is_null($data_temp)) {
                        continue;
                    }

                    $insert = [
                        'data_json' => json_encode($calendar),
                        'user_id' => 1,
                        'iCalUID' => $calendar->iCalUID,
                        'location' => $calendar->location,
                        'status' => $calendar->status,
                        'summary' => $calendar->summary,
                        'updated' => $calendar->updated,
                        'creator' => json_encode($calendar->creator),
                        'organizer' => json_encode($calendar->organizer),
                        'start' => $calendar->start['dateTime'] !== null ? $calendar->start['dateTime'] : $calendar->start['date'] . 'T' . Carbon::now()->format('H:i:s') . '+07:00',
                        'end' => $calendar->end['dateTime'] !== null ? $calendar->end['dateTime'] : $calendar->end['date'] . 'T' . Carbon::now()->addHour(2)->format('H:i:s') . '+07:00',
                        'created' => $calendar['created'],
                        'updated_at' => Carbon::now(),
                        'htmlLink' => json_encode($calendar->htmlLink),
                    ];
                    //echo $calendar->summary.'<br><br>';
                    $data_temp->update($insert);
                    continue;
                }
                $inserts[] = [
                    'data_json' => json_encode($calendar),
                    'user_id' => 1,
                    'iCalUID' => $calendar->iCalUID,
                    'location' => $calendar->location,
                    'status' => $calendar->status,
                    'summary' => $calendar->summary,
                    'updated' => $calendar->updated,
                    'creator' => json_encode($calendar->creator),
                    'organizer' => json_encode($calendar->organizer),
                    'start' => $calendar->start['dateTime'] !== null ? $calendar->start['dateTime'] : $calendar->start['date'] . 'T' . Carbon::now()->format('H:i:s') . '+07:00',
                    'end' => $calendar->end['dateTime'] !== null ? $calendar->end['dateTime'] : $calendar->end['date'] . 'T' . Carbon::now()->addHour(2)->format('H:i:s') . '+07:00',
                    'created' => $calendar['created'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'htmlLink' => json_encode($calendar->htmlLink),
                ];
                $temp_data[] = $calendar['created'];
            }
            if (!empty($inserts)) {
                $insert_success = JsonData::with('owner')->insert($inserts);
                if (!$insert_success) {
                    return response()->json(['status' => 'Unable to process your request right now, Please contact to System admin @070375783']);
                }
            }
            return response()->json(['status' => 'Success Data inserted/updated successfully.']);
        } catch (Google_Service_Exception $exception) {
            return response()->json(['status' => 'Error Data inserted/updated successfully.']);
        }
    }
}
