<?php

namespace App\Models\Music\Spotify;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $casts = ['id' => 'string'];
    public function users(){
        return $this->belongsToMany(User::class,'track_user');
    }
}
