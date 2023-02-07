<?php

namespace App\Http\Controllers;

use App\Models\Music;
use App\Http\Requests\StoreMusicRequest;
use App\Http\Requests\UpdateMusicRequest;
use http\Env\Request;

class MusicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreMusicRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMusicRequest $request)
    {
        $data = $request->validated();
        $music = Music::create($data);
        return response()->json([]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Music $music
     * @return \Illuminate\Http\Response
     */
    public function show($music)
    {
        $m = $this->getMusic($music);
        return is_null($m) ? response([
            'status' => 'ERROR',
            'error' => '404 not found'
        ], 404)
            : $m;

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateMusicRequest $request
     * @param \App\Models\Music $music
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMusicRequest $request, Music $music)
    {
        $data = $request->validated();
        $music->update($data);
        return response()->json([],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Music $music
     * @return \Illuminate\Http\Response
     */
    public function destroy(Music $music)
    {
        $music->delete();
        return response()->json([],200);
    }
    public  function updatePlaylist(StoreMusicRequest $request){
        $data = $request->validated();
        $music=$this->getMusic($request->spotify_id);
        if(is_null($music)){
            $this->store($request);
        }
    }
    private function getMusic($music){
        return Music::where('id', $music)
            ->orwhere('spotify_id', $music)
            ->first();
    }
}
