<?php

namespace App\Http\Controllers\Music\Spotify;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAlbumRequest;
use App\Http\Requests\UpdateAlbumRequest;
use App\Lib\ProcessingResponseApi\ProcessingResponseSpotify;
use App\Lib\Response\Error;
use App\Models\Music\Spotify\Album;
use App\Models\Music\Spotify\Artist;
use Illuminate\Support\Facades\Auth;

class AlbumController extends Controller
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
        return response()-json(Auth::user()->albumsSpotify);
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
     * @param  \App\Http\Requests\StoreAlbumRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAlbumRequest $request)
    {
        $data = $request->validated();
        $album = Album::find($data['id']);
        if (is_null($album)) {
            $arr = ProcessingResponseSpotify::album($data['id']);
            if (empty($arr))
                return Error::notFount();
            $album = Album::create($arr);
        }
        $user = Auth::user();
        $user->albumsSpotify()->attach($album->id);
        return response()->json($album);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Music\Spotify\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function show(Album $album)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Music\Spotify\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function edit(Album $album)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAlbumRequest  $request
     * @param  \App\Models\Music\Spotify\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAlbumRequest $request, Album $album)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Music\Spotify\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function destroy(Album $album)
    {
        $user = Auth::user();
        $user->tracksSpotify()->detach($album->id);
        return response()->json($album);
    }
}
