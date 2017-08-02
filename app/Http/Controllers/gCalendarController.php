<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Google_Service_Calendar_EventDateTime;
use Illuminate\Http\Request;
use Google_Service_Exception;

class gCalendarController extends BaseController
{
    protected $client;

    /**
     * gCalendarController constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Google_Service_Calendar_Event|\Illuminate\Http\Response
     */
    public function index()
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
            //return $calendars;
            return view('app.calendar.index', compact('calendars'));

        } catch (Google_Service_Exception $exception) {
            return response()->json(['Error' => 'មានបញ្ហាបច្ចេកទេស ក្នុងការទាញយកទិន្នន័យពី Google Calendar']);
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function oauth()
    {
        session_start();
        $rurl = action('gCalendarController@oauth');
        $this->client->setRedirectUri($rurl);
        if (!isset($_GET['code'])) {
            $auth_url = $this->client->createAuthUrl();
            $filtered_url = filter_var($auth_url, FILTER_SANITIZE_URL);
            return redirect($filtered_url);
        } else {
            $this->client->authenticate($_GET['code']);
            $_SESSION['access_token'] = $this->client->getAccessToken();
            return redirect()->route('app.gcalendars.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('app.calendar.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        session_start();
        $startDateTime = $request->start_date;
        $endDateTime = $request->end_date;
        if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
            $this->client->setAccessToken($_SESSION['access_token']);
            $service = new Google_Service_Calendar($this->client);
            $calendarId = 'primary';
            $event = new Google_Service_Calendar_Event([
                'summary' => $request->title,
                'description' => $request->description,
                'start' => ['dateTime' => $startDateTime],
                'end' => ['dateTime' => $endDateTime],
                'reminders' => ['useDefault' => true],
            ]);
            $results = $service->events->insert($calendarId, $event);
            if (!$results) {
                return response()->json(['status' => 'error', 'message' => 'Something went wrong']);
            }
            return response()->json(['status' => 'success', 'message' => 'Event Created']);
        } else {
            return redirect()->route('oauthCallback');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $eventId
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function show($eventId)
    {
        session_start();
        if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
            $this->client->setAccessToken($_SESSION['access_token']);
            $service = new Google_Service_Calendar($this->client);
            $event = $service->events->get('primary', $eventId);
            if (!$event) {
                return response()->json(['status' => 'error', 'message' => 'Something went wrong']);
            }
            return response()->json(['status' => 'success', 'data' => $event]);
        } else {
            return redirect()->route('oauthCallback');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        session_start();
        if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
            $this->client->setAccessToken($_SESSION['access_token']);
            $service = new Google_Service_Calendar($this->client);
            $event = $service->events->get('primary', $id);
            if (!$event) {
                return response()->json(['status' => 'error', 'message' => 'Something went wrong']);
            }
            return response()->json(['status' => 'success', 'data' => $event]);
        } else {
            return redirect()->route('oauthCallback');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param $eventId
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function update(Request $request, $eventId)
    {
        session_start();
        if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
            $this->client->setAccessToken($_SESSION['access_token']);
            $service = new Google_Service_Calendar($this->client);
            $startDateTime = Carbon::parse($request->start_date)->toRfc3339String();
            $eventDuration = 30; //minutes
            if ($request->has('end_date')) {
                $endDateTime = Carbon::parse($request->end_date)->toRfc3339String();
            } else {
                $endDateTime = Carbon::parse($request->start_date)->addMinutes($eventDuration)->toRfc3339String();
            }
            // retrieve the event from the API.
            $event = $service->events->get('primary', $eventId);
            $event->setSummary($request->title);
            $event->setDescription($request->description);
            //start time
            $start = new Google_Service_Calendar_EventDateTime();
            $start->setDateTime($startDateTime);
            $event->setStart($start);
            //end time
            $end = new Google_Service_Calendar_EventDateTime();
            $end->setDateTime($endDateTime);
            $event->setEnd($end);
            $updatedEvent = $service->events->update('primary', $event->getId(), $event);
            if (!$updatedEvent) {
                return response()->json(['status' => 'error', 'message' => 'Something went wrong']);
            }
            return response()->json(['status' => 'success', 'data' => $updatedEvent]);
        } else {
            return redirect()->route('oauthCallback');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $eventId
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function destroy($eventId)
    {
        session_start();
        if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
            $this->client->setAccessToken($_SESSION['access_token']);
            $service = new Google_Service_Calendar($this->client);
            $service->events->delete('primary', $eventId);
            return response()->json(['status' => 'success', 'data' => 'Event deleted successfully']);
        } else {
            return redirect()->route('oauthCallback');
        }
    }

    public function getDataG()
    {
        try {
            session_start();
            if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
                $this->client->setAccessToken($_SESSION['access_token']);
                $service = new Google_Service_Calendar($this->client);
                $calendarId = 'primary';
                $optParams = array(
                    'maxResults' => 10,
                    'orderBy' => 'startTime',
                    'singleEvents' => TRUE,
                    //'timeMin' => date('c'),
                );
                $results = $service->events->listEvents($calendarId, $optParams);
                $calendars = $results->getItems();
                //return $calendars;
                return view('app.calendar.index', compact('calendars'));
            } else {
                return redirect()->route('oauthCallback');
            }
        } catch (Google_Service_Exception $exception) {
            session_destroy();
            if ($this->client->isAccessTokenExpired()) {
                $this->client->refreshToken('refresh-token');
            }
            return response()->json(['Error' => 'Get not get data from Google Calendar']);
        }
    }
}
