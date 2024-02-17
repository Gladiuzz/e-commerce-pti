<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CourierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function costCourier($id, Request $request)
    {
        $api_key = 'aac5c6a412ce463ccbf3f121bc4fe98d';
        $url = 'https://api.rajaongkir.com/starter/cost';

        $body = array(
            'origin' => 428,
            'destination' => $id,
            'weight' => 1,
            'courier' => "jne",
        );

        $response = Http::withHeaders([
            'key' => $api_key,
        ])->post($url, $body);

        return response()->json(['data' => json_decode($response), 'test' => $request->all()]);
    }

    public function getCity($id)
    {
        $api_key = 'aac5c6a412ce463ccbf3f121bc4fe98d';
        $url = "https://api.rajaongkir.com/starter/city";

        $body = array(
            // 'id' => 39,
            'province' => $id
        );

        $response = Http::withHeaders([
            'key' => $api_key
        ])->get($url,$body);

        return response()->json(['data' => json_decode($response)]);
    }

    public function getProvince()
    {
        $api_key = 'aac5c6a412ce463ccbf3f121bc4fe98d';
        $url = "https://api.rajaongkir.com/starter/province";


        $response = Http::withHeaders([
            'key' => $api_key
        ])->get($url);

        return response()->json(['data' => json_decode($response)]);
    }
}
