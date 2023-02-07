<?php

namespace App\Http\Controllers\Music\Spotify;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTrackRequest;
use App\Http\Requests\UpdateTrackRequest;
use App\Lib\ApiSpotify;
use App\Lib\ProcessingResponseApi\ProcessingResponseSpotify;
use App\Lib\Response\Error;
use App\Models\Music\Spotify\Track;
use Illuminate\Support\Facades\Auth;

class TrackController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()-json(Auth::user()->tracksSpotify);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreTrackRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTrackRequest $request)
    {
        $data = $request->validated();

        $track = Track::find($data['id']);
        if (is_null($track)) {
            $arr = ProcessingResponseSpotify::track($data['id']);
            if (empty($arr))
                return Error::notFount();
            $track = Track::create($arr);
        }
        $user = Auth::user();
        $user->tracksSpotify()->attach($track->id);
        return response()->json($track);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Music\Spotify\Track $track
     * @return \Illuminate\Http\Response
     */
    public function show(Track $track)
    {
        return response()-json($track);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Music\Spotify\Track $track
     * @return \Illuminate\Http\Response
     */
    public function destroy(Track $track)
    {
        $user = Auth::user();
        $user->tracksSpotify()->detach($track->id);
        return response()->json($track);
    }
    public function lyrics(Track $track)
    {
        return response()->json(ProcessingResponseSpotify::lyrics($track->id),200);
    }
}
