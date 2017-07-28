<?php
/**
 * Created by PhpStorm.
 * User: Chantouch
 * Date: 7/28/2017
 * Time: 3:42 PM
 */

namespace App\Services;

use App\Model\TempData;
use Carbon\Carbon;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Exception;
use Illuminate\Console\Command;

class SyncGoogleCalendarService
{

    protected $client;

    /**
     * gCalendarController constructor.
     */
    public function __construct()
    {
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
     * @param $command
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function sync(Command $command)
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
                    $command->info('Unable to process your request right now, Please contact to System admin @070375783');
                }
                $command->info('Data inserted/updated successfully.');
            }
            if ($added) {
                $command->info('Google:Sync Command Run added successfully!');
            } else {
                $command->info('Google:Sync Command Run added/updated with exist!');
            }

        } catch (Google_Service_Exception $exception) {
            $command->info('Google:Sync Command Run unsuccessfully!');
        }
    }
}