<?php

namespace App;

use App\Wish;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $appends = array('is_friend');

    protected static function boot() {
		parent::boot();
		static::addGlobalScope('wishes', function ($builder) {
			$builder->with('wishes');
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function wishes() {
        return $this->hasMany(Wish::class);
    }

    public function friends() {
        return $this->belongsToMany('App\User','friends','user_id','friend_id');
    }

    public function getIsFriendAttribute() {
        return $this->isFriend();
    }

    public function isFriend() {
        return auth()->check() && Friend::where([
            'user_id'=>auth()->id(),
            'friend_id'=>$this->id
        ])->exists();
    }

    public function befriend() {
        if ( ! $this->isFriend()) {
            Friend::create([
                'user_id'=>auth()->id(),
                'friend_id'=>$this->id
            ]);
        }
    }

    public function unfriend() {
        if ($this->isFriend()) {
            Friend::where([
                'user_id'=>auth()->id(),
                'friend_id'=>$this->id
            ])->delete();
        }
    }
}
