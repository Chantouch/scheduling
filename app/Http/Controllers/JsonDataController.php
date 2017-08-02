<?php

namespace App\Http\Controllers;

use App\Model\JsonData;
use Illuminate\Http\Request;

class JsonDataController extends BaseController
{
    /**
     * JsonDataController constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function show($id)
    {
        $json = JsonData::find($id);
        // json object.
        $contents = '{"firstName":"John", "lastName":"Doe"}';
        // Option 1: through the use of an array.
        //$jsonArray = json_decode($json->data_json, true);
        $key = "id";
        //$firstName = $jsonArray[$key];
        // Option 2: through the use of an object.
        $jsonObj = json_decode($json->data_json);
        $summary = $jsonObj->summary;
        //dd($jsonObj);
        return response()->json($jsonObj);
    }
}
