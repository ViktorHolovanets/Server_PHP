<?php
namespace App\Models;

namespace App\Models;

use App\Models\Music\Spotify\Album;
use App\Models\Music\Spotify\Artist;
use App\Models\Music\Spotify\Track;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;


class User extends Authenticatable implements JWTSubject
{
    use  HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email',
        'role_id',
    ];
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'id'=>'string'
    ];
    public function role(){
        return $this->belongsTo(Role::class);
    }
    public function news(){
        return $this->hasMany(News::class);
    }
    public function music(){
        return $this->belongsToMany(Music::class,'music_user');
    }
    public function tracksSpotify(){
        return $this->belongsToMany(Track::class,'track_user');
    }
    public function artistsSpotify(){
        return $this->belongsToMany(Artist::class);
    }
    public function albumsSpotify(){
        return $this->belongsToMany(Album::class);
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'leader_id', 'follower_id')->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followings()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'leader_id')->withTimestamps();
    }


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }


    public function getJWTCustomClaims()
    {
        return [];
    }

}
