<?php

namespace App\Console\Commands;

use App\Model\JsonData;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Exception;

class SyncGoogleCalendar extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'google:sync';
    protected $client;
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize all data from google calendars that including new and old.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $client = new Google_Client();
        $client->addScope(Google_Service_Calendar::CALENDAR);
        $guzzleClient = new \GuzzleHttp\Client(array('curl' => array(CURLOPT_SSL_VERIFYPEER => false)));
        $client->setHttpClient($guzzleClient);
        $client->setApplicationName("Google Calendar Of DG");
        $apiKey = 'AIzaSyCzmINkqTeDAhuA3Y-ZhCVYp6FSziQplcg';
        $client->setDeveloperKey($apiKey);
        $this->client = $client;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $service = new Google_Service_Calendar($this->client);
            $calendarId = 'dg.gdnt@gmail.com';
            $minDate = date('Y-m-d', strtotime('-14400 days')) . "T00:00:00-04:00";
            $maxDate = date('Y-m-d', strtotime('+720 days')) . "T00:00:00-04:00";
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
                        'user_id' => 1,
                        'data_json' => json_encode($calendar),
                        'iCalUID' => $calendar->iCalUID,
                        'location' => $calendar->location,
                        'status' => $calendar->status,
                        'summary' => $calendar->summary,
                        'updated' => $calendar->updated,
                        'creator' => json_encode($calendar->creator),
                        'organizer' => json_encode($calendar->organizer),
                        'start' => $calendar->start['dateTime'] !== null ? $calendar->start['dateTime'] : $calendar->start['date'] . 'T10:00:00+07:00',
                        'end' => $calendar->end['dateTime'] !== null ? $calendar->end['dateTime'] : $calendar->end['date'] . 'T20:00:00+07:00',
                        'created' => $calendar['created'],
                        'updated_at' => Carbon::now(),
                        'htmlLink' => json_encode($calendar->htmlLink),
                    ];
                    $data_temp->update($insert);
                    continue;
                }
                $inserts[] = [
                    'user_id' => 1,
                    'data_json' => json_encode($calendar),
                    'iCalUID' => $calendar->iCalUID,
                    'location' => $calendar->location,
                    'status' => $calendar->status,
                    'summary' => $calendar->summary,
                    'updated' => $calendar->updated,
                    'creator' => json_encode($calendar->creator),
                    'organizer' => json_encode($calendar->organizer),
                    'start' => $calendar->start['dateTime'] !== null ? $calendar->start['dateTime'] : $calendar->start['date'] . 'T10:00:00+07:00',
                    'end' => $calendar->end['dateTime'] !== null ? $calendar->end['dateTime'] : $calendar->end['date'] . 'T20:00:00+07:00',
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
                    $this->info('Unable to process your request right now, Please contact to System admin @070375783');
                }
                $this->info('Data inserted/updated successfully.');
            }
            if ($updated) {
                $this->info('Google:Sync Command Run added successfully!');
            } else {
                $this->info('Google:Sync Command Run added/updated with exist!');
            }
        } catch (Google_Service_Exception $exception) {
            $this->info('Google:Sync Command Run unsuccessfully!');
        }
        $this->info('Google:Sync Command Run successfully in last step!');
    }
}
