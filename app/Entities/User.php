<?php

namespace App\Entities;

use App\Entities\Traits\UuidModel;
use App\Settings\InitialSettings;
use App\Settings\Settings;
use Carbon\Carbon;
use Iatstuti\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Backpack\CRUD\CrudTrait;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * App\Entities\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $password
 * @property mixed|null $settings
 * @property int $verified
 * @property string|null $email_token
 * @property string|null $avatar
 * @property string|null $remember_token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Portfolio[] $portfolios
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Role[] $roles
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereEmailToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereSettings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereVerified($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use Notifiable, CrudTrait, HasRoles, UuidModel, SoftDeletes, CascadeSoftDeletes, HasApiTokens;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'email_new',
        'password',
        'settings',
        'email_token',
        'verified',
        'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token', 'id'];

    protected $cast = ['settings' => 'json'];

    protected $cascadeDeletes = ['portfolios'];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];



    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function portfolios()
    {

        return $this->hasMany(Portfolio::class);

    }

    public function obtain(Portfolio $portfolio)
    {
        $this->portfolios()->save($portfolio);
    }


    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function settings($key = null)
    {
        $settings = new Settings($this);

        return $key ? $settings->get($key) : $settings;
    }


    public function hasPassword()
    {
        return !is_null($this->password);
    }


    public function newEmailRequiresVerification()
    {
        return ($this->validToken()->count() && ($this->email_new));
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeUnverified($query)
    {
        return $query->where('verified', 0);
    }

    public function scopeVerified($query)
    {
        return $query->where('verified', 1);
    }

    public function scopeValidToken($query)
    {
        return $query->where('email_token_expires_at', '>=', Carbon::now());
    }

    public function scopeExpiredToken($query)
    {
        return $query->where('email_token_expires_at', '<', Carbon::now());
    }


    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */


    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name'] = ucfirst($value);
    }

    public function setLastNameAttribute($value)
    {
        $this->attributes['last_name'] = ucfirst($value);
    }
}
