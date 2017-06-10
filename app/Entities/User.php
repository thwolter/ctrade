<?php

namespace App\Entities;

use App\Settings;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use LaravelPropertyBag\Settings\HasSettings;

class User extends Authenticatable
{
    use Notifiable;
    use HasSettings;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'settings'
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

}
