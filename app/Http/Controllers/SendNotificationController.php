<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class SendNotificationController extends Controller
{
    //
    function sendNotificationToPembeli($heading, $message)
    {
        $client = new Client();
        $content = [
            'en' => $message
        ];
        $heading = [
            'en' => $heading
        ];
        $response = $client->request('POST', 'https://onesignal.com/api/v1/notifications', array(
            'headers' => [
                'Content-Type' => 'application/json; charset=utf-8',
                'Authorization' => 'Basic YzIzOWFkYjctZDdjZS00NTg2LWI5OTgtNDgwMTcwMGIxMGJi'
            ],
            'json' => [
                'app_id' => "2c06bc85-9b49-44c7-952c-46c2cf3bbc8a",
                'included_segments' => array(
                    'Subscribed Users'
                ),
                'headings' => $heading,
                'contents' => $content,
                'android_sound' => 'notif',
                'small_icon' => 'ic_stat_name',
                'android_channel_id' => 'f80c8eea-d54e-4aa7-be5c-25fa3400997b'
            ]
        ));

        return [
            'status' => 1,
            'data' => $response
        ];
    }
    function sendNotificationToAppRN($heading, $message, $data)
    {
        $client = new Client();
        $content = [
            'en' => $message
        ];
        $heading = [
            'en' => $heading
        ];
        $response = $client->request('POST', 'https://onesignal.com/api/v1/notifications', array(
            'headers' => [
                'Content-Type' => 'application/json; charset=utf-8',
                'Authorization' => 'Basic NTZmZGJmN2EtODUxYy00M2RiLTk4YWUtYTBhZmEzYzFjZGRi'
            ],
            'json' => [
                'app_id' => "8524462f-5ef3-4610-8c9f-1f19a8d72fbb",
                'filters' => array(array("field" => "tag", "key" => "user_id_unreal", "relation" => "=", "value" => $data['id_user'])),
                'headings' => $heading,
                'contents' => $content,
                'android_sound' => 'notif',
                'small_icon' => 'ic_stat_name',
                'android_channel_id' => 'dfa17307-f204-4f1b-8cf6-8fd336d663f5'
            ]
        ));

        return [
            'status' => 1,
            'data' => $response
        ];
    }
}
