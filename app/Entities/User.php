<?php

namespace App\Entities;

use App\Settings\UserSettings;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'settings', 'email_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $cast =[
        'settings' => 'json'
    ];


    public function portfolios() {

        return $this->hasMany(Portfolio::class);

    }

    public function obtain(Portfolio $portfolio)
    {
        $this->portfolios()->save($portfolio);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }


    public function settings($key = null)
    {
        $settings = new UserSettings($this);

        return $key ? $settings->get($key) : $settings;
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function($user) {
            $user->email_token = str_random(30);
        });
    }
}
