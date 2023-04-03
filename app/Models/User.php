<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
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
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function achievements()
    {
        return $this->belongsToMany(Achievement::class, 'user_achievement')->withTimestamps();
    }

    public function current_achievement()
    {
        return $this->achievements()->orderByPivot('created_at', 'desc')->limit(1);
    }

    /**
     * Badges earned by a user
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function badges(){
        return $this->belongsToMany(Badge::class)->withTimestamps();
    }

    public function current_badge(){
        return $this->badges()->orderByPivot('created_at', 'desc')->limit(1);
    }
}
