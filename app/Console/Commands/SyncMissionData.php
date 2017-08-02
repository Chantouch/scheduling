<?php

namespace App\Console\Commands;

use App\Model\JsonData;
use App\Model\Mission;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Exception;

class SyncMissionData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:missions';
    protected $client;
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To run sync local data of mission form json temporary.';

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
            $query = 'បេសកកម្ម';
            $meetings = Mission::with('user')->pluck('created')->toArray();
            $temp_data = JsonData::with('owner')
                ->where('summary', 'like', '%' . $query . '%')
                ->orWhere('summary', 'like', '%' . 'Mission' . '%')
                ->orWhere('summary', 'like', '%' . 'Missions' . '%')
                ->get();
            $inserts = [];
            $updated = false;
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
                        'start_date' => substr($replace_start, 0, -9),
                        'end_date' => substr($replace_end, 0, -9),
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
                    'start_date' => substr($replace_start, 0, -9),
                    'end_date' => substr($replace_end, 0, -9),
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
