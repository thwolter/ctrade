<?php

namespace App\Entities;

use App\Entities\Traits\UuidModel;
use App\Events\PortfolioHasChanged;
use App\Presenters\Presentable;
use App\Repositories\PositionRepository;
use App\Repositories\TransactionRepository;
use App\Settings\PortfolioSettings;
use App\Settings\Settings;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Iatstuti\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Financable;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\UploadedFile;
use Psy\Readline\Libedit;


/**
 * App\Entities\Portfolio
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string|null $description
 * @property int|null $category_id
 * @property float $cash
 * @property int $currency_id
 * @property array $settings
 * @property int $public
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Entities\Category|null $category
 * @property-read \App\Entities\Currency $currency
 * @property-read mixed $category_name
 * @property-read mixed $image_url
 * @property-read \App\Entities\PortfolioImage $image
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Keyfigure[] $keyFigures
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Limit[] $limits
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Position[] $positions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Transaction[] $transactions
 * @property-read \App\Entities\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Portfolio whereCash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Portfolio whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Portfolio whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Portfolio whereCurrencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Portfolio whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Portfolio whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Portfolio whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Portfolio wherePublic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Portfolio whereSettings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Portfolio whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Portfolio whereUserId($value)
 * @mixin \Eloquent
 */
class Portfolio extends Model
{
    use Presentable, UuidModel, Sluggable, SluggableScopeHelpers, SoftDeletes, CascadeSoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $presenter = 'App\Presenters\Portfolio';

    protected $fillable = ['name', 'description', 'settings', 'img_url'];

    protected $casts = ['settings' => 'json'];

    protected $hidden = ['id'];

    protected $cascadeDeletes = [
        'positions',
        'transactions',
        'category',
        'keyFigures',
        'limits',
        'image'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'];

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


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function keyFigures()
    {
        return $this->hasMany(Keyfigure::class);
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

    public function settings($key = null)
    {
        $settings = new PortfolioSettings($this);
        return $key ? $settings->get($key) : $settings;
    }

    public function currencyCode()
    {
        return $this->currency->code;
    }

    public function cash()
    {
        return $this->payments()->sum('amount');
    }

    public function cashFlow($from, $to)
    {
        return $this->payments()->whereBetween('executed_at', [$from, $to])->sum('amount');
    }

    public function totalOfType($type = null)
    {
        $assets = $type ? $this->assets()->ofType($type) : $this->assets();
        $sum = 0;
        foreach($assets->get() as $asset)
        {
            $sum += $asset->value();
        }
        return $sum;
    }

    public function total()
    {
        return $this->totalOfType(null) + $this->cash();
    }


    public function setCurrency($code)
    {
        $this->currency()->associate(Currency::firstOrCreate(['code' => $code]));
    }

    public function saveKeyFigure($key, $value, $date)
    {
        $keyFigure = Keyfigure::make($key, $value, $date);
        $this->keyFigures()->save($keyFigure);

        return $this;
    }

    public function toArray()
    {
        $array = [
            'meta' => [
                'name' => $this->name,
                'currency' => $this->currencyCode(),
                'cash' => $this->cash()
            ],
            'items' => []
        ];

        foreach ($this->assets()->get() as $asset)
        {
            $array['items'][$asset->id] = $asset->toArray();
        }
        return $array;
    }



    /* --------------------------------
     * Functions to manage transactions
     * --------------------------------
     */

    /**
     * Return the instrument from an attributes array.
     *
     * @param array $attributes
     * @return mixed
     */
    private function getInstrument($attributes)
    {
        $instrument = resolve($attributes['instrumentType'])->find($attributes['instrumentId']);
        return $instrument;
    }

    /**
     * A buy transaction for position with a given id.
     *
     * @param array $attributes
     * @return Portfolio
     */
    public function tradePosition($attributes)
    {
        $this->assets()->firstOrCreate([
            'positionable_type' => $attributes['instrumentType'],
            'positionable_id' => $attributes['instrumentId']
        ])->obtain($attributes['amount'], $attributes['executed']);

        $this->payments()->create([
            'type' => 'trade',
            'amount' => -$attributes['price'] * $attributes['amount'],
            'executed_at' => $attributes['executed']
        ]);

        return $this->payFees($attributes);
    }


    /**
     * Deposit an amount of cash.
     *
     * @param array $attributes
     * @return $this
     */
    public function deposit($attributes)
    {
        $this->payments()->create([
            'type' => 'deposit',
            'amount' => $attributes['amount'],
            'executed_at' => $attributes['date']
        ]);

        return $this;
    }

    /**
     * Withdraw an amount of cash.
     *
     * @param array $attributes
     * @return $this
     */
    public function withdraw($attributes)
    {
        $this->payments()->create([
            'type' => 'withdraw',
            'amount' => -$attributes['amount'],
            'executed_at' => $attributes['executed']
        ]);

        return $this;
    }

    /**
     * Deduct fees from portfolio cash.
     *
     * @param array $attributes
     * @return Portfolio
     */
    public function payFees($attributes)
    {
        $this->payments()->create([
            'type' => 'fees',
            'amount' => -$attributes['fees'],
            'executed_at' => $attributes['executed']
        ]);

        return $this;
    }

    /* --------------------------------------------
    * Functions for portfolio images
    * --------------------------------------------
    */

    public function addImage(UploadedFile $file)
    {
        $image = PortfolioImage::fromForm($file);
        $file->storeAs($this->imagesPath . '', $image->path);

        return $this->image()->save($image);
    }

    public function updateImage(UploadedFile $file)
    {
        $image = PortfolioImage::fromForm($file);

        \Storage::delete($this->imagesPath . $this->image->path);

        $file->storeAs($this->imagesPath, $image->path);
        $this->image->path = $image->path;

        $this->image->update();

        return $this;
    }

    public function deleteImage()
    {
        \Storage::delete('public/images/' . $this->image->path);

    }


    /**
     * Return the keyFigures of chosen type. If not exists in database it will be craated.
     *
     * @param string $type
     * @return Keyfigure
     */
    public function keyFigure($type)
    {
        $keyFigure = $this->keyfigures()->ofType($type)->first();

        if (!$keyFigure) {
            $keyFigure = new Keyfigure();
            $keyFigure->type()->associate(KeyfigureType::firstOrCreate(['code' => $type]));
            $this->keyFigures()->save($keyFigure);
        }

        return $keyFigure;
    }

    public function sluggable()
    {
        return ['slug' => ['source' => 'name']];
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function latestTransactionDate()
    {
        $payment = $this->payments()->latest()->first();
        $position = $this->positions()->latest()->first();

        return max(
            ($payment) ? $payment->executed_at : null,
            ($position) ? $position->executed_at : null
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

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
