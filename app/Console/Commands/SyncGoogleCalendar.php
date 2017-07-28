<?php

namespace App\Console\Commands;

use App\Model\TempData;
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

    private $g_calendars = null;
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
            $optParams = array(
                'orderBy' => 'startTime',
                'singleEvents' => TRUE,
            );
            $results = $service->events->listEvents($calendarId, $optParams);
            $calendars = $results->getItems();
            $temp_data = TempData::with('user')->pluck('created')->toArray();
            $updated = false;
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
                        'user_id' => 1
                    ];
                    $updated = $data_temp->update($update_date);
                    continue;
                }
                $inserts[] = [
                    'data' => $calendar['summary'],
                    'created' => $calendar['created'],
                    'created_at' => Carbon::now(),
                    'updated' => $calendar['updated'],
                    'updated_at' => Carbon::now(),
                    'user_id' => 1
                ];
                $temp_data[] = $calendar['created'];
            }
            if (!empty($inserts)) {
                $insert_success = TempData::with('user')->insert($inserts);
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
