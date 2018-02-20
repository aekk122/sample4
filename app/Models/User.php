<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPassword;
use Auth;

class User extends Authenticatable
{
    use Notifiable;

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

    protected $table = 'users';

    public function gravatar($size = '100') {
        $hash = md5(strtolower(trim($this->email)));
        return "http://www.gravatar.com/avatar/$hash?s=$size";
    }

    public static function boot() {
        parent::boot();

        static::creating(function ($user) {
            $user->activation_token = str_random(30);
        });
    }

    public function sendPasswordResetNotification($token) {
        $this->notify(new ResetPassword($token));
    }

    public function hasManyStatuses() {
        return $this->hasMany(Status::class, 'user_id', 'id');
    }

    public function getAllStatuses() {
        $user_ids = Auth::user()->hasManyFollows->pluck('id')->toArray();
        array_push($user_ids, Auth::user()->id);
        $statuses = Status::whereIn('user_id', $user_ids)->with('belongsToUser')->orderBy('created_at', 'desc');
        return $statuses;
    }

    public function hasManyFollowers() {
        return $this->belongsToMany(User::class, "followers", 'user_id', 'follower_id');
    }

    public function hasManyFollows() {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id');
    }

    public function follow($user_ids) {
        if (!is_array($user_ids)) {
            $user_ids = compact('user_ids');
        }

        $this->hasManyFollows()->sync($user_ids, false);
    }

    public function unfollow($user_ids) {
        if (!is_array($user_ids)) {
            $user_ids = compact("user_ids");
        }

        $this->hasManyFollows()->detach($user_ids);
    }

    public function isFollowings($user_id) {
        return $this->hasManyFollows->contains($user_id);
    }
}
