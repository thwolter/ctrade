<?php

namespace App\Entities;

use App\Facades\AccountService;
use App\Presenters\PortfolioPresenter;
use App\Entities\Traits\UuidModel;
use App\Presenters\Presentable;
use App\Services\SettingServices\PortfolioSettings;
use App\Services\SettingServices\Settingable;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Iatstuti\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Portfolio extends Model
{
    use UuidModel, Sluggable, SluggableScopeHelpers, SoftDeletes, CascadeSoftDeletes;

    use Presentable, Settingable;


    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $presenter = PortfolioPresenter::class;
    protected $settingsService = PortfolioSettings::class;


    protected $fillable = [
        'name',
        'description',
        'settings',
        'img_url',
        'opened_at'
    ];

    protected $hidden = ['id'];

    protected $casts = [
        'settings' => 'json'
    ];

    protected $cascadeDeletes = [
        'positions',
        'keyFigures',
        'limits',
        'image'
    ];

    protected $dates = [
        'opened_at',
        'created_at',
        'updated_at',
        'deleted_at'
    ];


    public $imagesPath = 'public/images';

    protected $transaction;


    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function image()
    {
        return $this->hasOne(PortfolioImage::class);
    }


    public function keyfigures()
    {
        return $this->morphMany(Keyfigure::class, 'keyfigureable');
    }

    public function limits()
    {
        return $this->hasMany(Limit::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function assets()
    {
        return $this->hasMany(Asset::class);
    }

    public function positions()
    {
        return $this->hasManyThrough(Position::class, Asset::class,
            'portfolio_id', 'asset_id');
    }


    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */


    /**
     * Obtain an asset.
     *
     * @param Asset $asset
     * @return false|Model
     */
    public function obtain(Asset $asset)
    {
        return $this->assets()->save($asset);
    }


    /**
     * @param string $date
     * @return float
     */
    public function balance($date = '')
    {
        return $this->payments()->until($date)->sum('amount');
    }


    public function firstTransactionEnteredAfter($date)
    {
        if (!$date) return null;

        return collect(array_merge(
            $this->payments()->updatedAfter($date)->get()->all(),
            $this->positions()->updatedAfter($date)->get()->all()
        ))->sortBy('executed_at')->first();
    }


    public function lastTransaction()
    {
        return collect(array_merge(
            $this->payments->all(),
            $this->positions->all()
        ))->sortByDesc('executed_at')->first();
    }



    public function setCurrency($code)
    {
        $this->currency()->associate(Currency::firstOrCreate(['code' => $code]));
    }


    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'currency' => $this->currency->code,
            'cash' => AccountService::balance($this)->getValue(),
            'lastTransactionDate' => $this->lastTransactionDateString()
        ];
    }

    public function lastTransactionDateString()
    {
        $date = optional($this->lastTransaction())->executed_at;
        return $date ? $date->toDateString() : null;
    }



    public function sluggable()
    {
        return ['slug' => ['source' => 'name']];
    }


    public function getRouteKeyName()
    {
        return 'slug';
    }


    public function riskParameter($date = null)
    {
        $parameter = $this->settings()->only(['period', 'confidence', 'history']);

        return array_add(
            array_replace_key($parameter, 'history', 'count'), 'date', $date
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /**
     * Ensure that a slug is unique for a given user. Different users may have the same slug.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string $attribute
     * @param array $config
     * @param string $slug
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithUniqueSlugConstraints(Builder $query, Model $model, $attribute, $config, $slug)
    {
        $user = $model->user;

        return $query->where('user_id', $user->getKey());
    }


    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    public function getCategoryNameAttribute()
    {
        $default = $this->category;
        return (!is_null($default)) ? $default->name : 'keine Kategorie';
    }

    public function getImageUrlAttribute()
    {
        $file = $this->image;
        return (!is_null($file)) ? 'images/' . $file->path : null;
    }



    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
