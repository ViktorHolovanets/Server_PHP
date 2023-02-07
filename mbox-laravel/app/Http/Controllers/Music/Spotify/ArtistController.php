<?php

namespace App\Http\Controllers\Music\Spotify;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArtistRequest;
use App\Http\Requests\UpdateArtistRequest;
use App\Lib\ProcessingResponseApi\ProcessingResponseSpotify;
use App\Lib\Response\Error;
use App\Models\Music\Spotify\Artist;
use App\Models\Music\Spotify\Track;
use Illuminate\Support\Facades\Auth;

class ArtistController extends Controller
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
        return response()-json(Auth::user()->artistsSpotify);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreArtistRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArtistRequest $request)
    {
        $data = $request->validated();
        $artist = Artist::find($data['id']);
        if (is_null($artist)) {
            $arr = ProcessingResponseSpotify::artist($data['id']);
            if (empty($arr))
                return Error::notFount();
            $artist = Artist::create($arr);
        }
        $user = Auth::user();
        $user->artistsSpotify()->attach($artist->id);
        return response()->json($artist);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Music\Spotify\Artist  $artist
     * @return \Illuminate\Http\Response
     */
    public function show(Artist $artist)
    {
        return response()-json($artist);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Music\Spotify\Artist  $artist
     * @return \Illuminate\Http\Response
     */
    public function edit(Artist $artist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateArtistRequest  $request
     * @param  \App\Models\Music\Spotify\Artist  $artist
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateArtistRequest $request, Artist $artist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Music\Spotify\Artist  $artist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Artist $artist)
    {
        $user = Auth::user();
        $user->tracksSpotify()->detach($artist->id);
        return response()->json($artist);
    }
}
