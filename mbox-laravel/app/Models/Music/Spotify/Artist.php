<?php

namespace App\Models\Music\Spotify;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    use HasFactory;
    protected  $fillable=[
        'id',
        'name',
        'uri',
        'img',
    ];
    protected $casts = ['id' => 'string'];
    public function users(){
        return $this->belongsToMany(User::class);
    }
}
