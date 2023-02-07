<?php

namespace App\Lib;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiSpotify
{
    public static function requestApiSpotify( $url, $params)
    {
        $response = Http::withHeaders([
            'X-RapidAPI-Key' => env('API_PARID'),
            'X-RapidAPI-Host' => 'spotify23.p.rapidapi.com'
        ])->get($url, $params);
        return $response->body();
    }

    public static function search(Request $request)
    {
        $request->validate([
            'q' => 'string',
            'type' => 'string',
        ]);
        return self::requestApiSpotify( 'https://spotify23.p.rapidapi.com/search/', [
            'q' => $request->q,
            'type' => $request->type,
            'offset' => '0',
            'limit' => '10',
            'numberOfTopResults' => '5'
        ]);
    }

    public static function lyrics($id)
    {
        return self::requestApiSpotify( 'https://spotify23.p.rapidapi.com/track_lyrics/',[
            'id' => $id,
        ]);
    }

    public static function artists(Request $request)
    {
        $request->validate([
            'id' => 'string',
        ]);
        return self::requestApiSpotify( 'https://spotify23.p.rapidapi.com/artists/',[
            'id' => $request->id,
        ]);
    }
    public static function track($id)
    {
        return self::requestApiSpotify( 'https://spotify23.p.rapidapi.com/tracks/',[
            'ids' => $id,
        ]);
    }
}
