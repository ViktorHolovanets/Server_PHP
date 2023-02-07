<?php

namespace App\Lib\ProcessingResponseApi;

use App\Lib\ApiSpotify;
use http\Env\Request;

class ProcessingResponseSpotify
{
    public static function lyrics($id)
    {
        $json=ApiSpotify::lyrics($id);
        $arr = json_decode($json, true);
        if (empty($arr))
            return [];
        foreach ($arr['lyrics']['lines'] as $line) {
            $res[] = $line['words'];
        }
        return $res;
    }

    public static function tracks($json)
    {
        $arr = json_decode($json, true);
        if (empty($arr) || !array_key_exists('tracks', $arr))
            return [];

        foreach ($arr['tracks']['items'] as $track) {
            foreach ($track as $tr) {
                //dd($tr);
                $res[] = array(
                    "uri" => $tr['uri'],
                    "img" => $tr['albumOfTrack']['coverArt']['sources']['0']['url'],
                    "id" => $tr['id'],
                    "artists" => $tr['artists']['items']['0']['profile']['name'],
                    "artists_uri" => $tr['artists']['items']['0']['uri'],
                    "albums_uri" => $tr['albumOfTrack']['uri'],
                    "albums_name" => $tr['albumOfTrack']['name'],
                    "duration" => $tr['duration']['totalMilliseconds'],
                );
            }

        }
        return $res;
    }

    public static function artists($json)
    {
        $arr = json_decode($json, true);
        if (empty($arr) || !array_key_exists('artists', $arr))
            return [];
        foreach ($arr['artists']['items'] as $artist) {
            $res[] = array(
                "uri" => $artist['data']['uri'],
                "name" => $artist['data']['profile']['name'],
                "img" => $artist['data']['visuals']['avatarImage']['sources']['0']['url'] ?? "",
            );
        }
        return $res;
    }

    public static function albums($json)
    {
        $arr = json_decode($json, true);
        if (empty($arr) || !array_key_exists('albums', $arr))
            return [];
        foreach ($arr['albums']['items'] as $album) {
            $res[] = array(
                "uri" => $album['data']['uri'],
                "name" => $album['data']['name'],
                "img" => $album['data']['coverArt']['sources']['0']['url'] ?? '',
            );
        }
        return $res;
    }

    public static function track($id)
    {
        $arr = json_decode(ApiSpotify::track($id), true);
        if (is_null($arr['tracks'][0]) || !array_key_exists('tracks', $arr))
            return [];
        return [
            'id'=>$arr['tracks'][0]['id'],
            'uri'=>$arr['tracks'][0]['uri']??'',
            'img'=>$arr['tracks'][0]['album']['images'][0]['url']??'',
            'artists'=>$arr['tracks'][0]['artists'][0]['name']??'',
            'artists_uri'=>$arr['tracks'][0]['artists'][0]['uri']??'',
            'albums_name'=>$arr['tracks'][0]['album']['name']??'',
            'albums_uri'=>$arr['tracks'][0]['album']['uri']??'',
            'duration'=>$arr['tracks'][0]['duration_ms']??'',
        ];
    }
    public static function artist($id)
    {
        $arr = json_decode(ApiSpotify::requestApiSpotify('https://spotify23.p.rapidapi.com/artists/',['ids'=>$id]), true);
        if (is_null($arr['artists'][0]) || !array_key_exists('artists', $arr))
            return [];
        return  [
            'id'=>$arr['artists'][0]['id'],
            'uri'=>$arr['artists'][0]['uri']??'',
            'img'=>$arr['artists'][0]['images'][0]['url']??'',
            'name'=>$arr['artists'][0]['name']??'',
        ];
    }
    public static function album($id)
    {
        $arr = json_decode(ApiSpotify::requestApiSpotify('https://spotify23.p.rapidapi.com/albums/',['ids'=>$id]), true);
        if (is_null($arr['albums'][0]) || !array_key_exists('albums', $arr))
            return [];
        return  [
            'id'=>$arr['albums'][0]['id'],
            'uri'=>$arr['albums'][0]['uri']??'',
            'img'=>$arr['albums'][0]['images'][0]['url']??'',
            'name'=>$arr['albums'][0]['name']??'',
        ];
    }
}

