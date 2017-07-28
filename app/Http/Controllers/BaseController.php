<?php

namespace App\Http\Controllers;

use Google_Client;
use Google_Service_Calendar;

class BaseController extends Controller
{
    protected $client;

    /**
     * gCalendarController constructor.
     */
    public function __construct()
    {
        $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
        $client = new Google_Client();
        $client->setAuthConfig('client_secret.json');
        $client->setRedirectUri($redirect_uri);
        $client->addScope(Google_Service_Calendar::CALENDAR);
        $guzzleClient = new \GuzzleHttp\Client(array('curl' => array(CURLOPT_SSL_VERIFYPEER => false)));
        $client->setHttpClient($guzzleClient);
        $client->setApplicationName("Google Calendar Of DG");
        $apiKey = 'AIzaSyCzmINkqTeDAhuA3Y-ZhCVYp6FSziQplcg';
        $client->setDeveloperKey($apiKey);
        $this->client = $client;
    }
}
