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

    protected $fillable = ['name', 'cash', 'description', 'settings', 'img_url'];

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

    protected $dates = ['deleted_at'];

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

    public function positions()
    {
        return $this->hasMany(Position::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
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


    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->transaction = new TransactionRepository($this);
    }

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
        return $this->cash;
    }

    public function cashFlow($from, $to)
    {
        return $this->transactions()->payments()->between($from, $to)->sum('value');
    }

    public function stockTotal()
    {
        return $this->positions->sum->total($this->currencyCode());
    }

    public function total()
    {
        return $this->stockTotal() + $this->cash();
    }

    public function value()
    {
        return $this->total() + $this->cash();
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
                'cash' => $this->cash
            ],
            'items' => []
        ];

        foreach ($this->positions as $position) {

            $array['items'][$position->id] = $position->toArray();
        }
        return $array;
    }


    public function makePosition($instrument, $datasource = null)
    {
        $position =  $this->positions()->withInstrument($instrument)->first();

        if (! $position) {
            $position = (new PositionRepository())->createPosition($instrument, $datasource);
            $this->positions()->save($position);
        }

        return $position;
    }


    /* ------------------------------------
     * Functions to buy and sell a position
     * ------------------------------------
     */

    /**
     * A buy transaction for position with a given id.
     *
     * @param Position $position
     * @param array $attributes
     * @return Portfolio
     */
    public function buy($position, $attributes)
    {
        $this->transaction->trade($position, $attributes);
        $this->makeTrade($position, $attributes['amount'])->save();

        return $this;
    }

    /**
     * A sell transaction for position with a given id
     *
     * @param Position $position
     * @param array $attributes
     * @return mixed
     */
    public function sell($position, $attributes)
    {
        $this->transaction->trade($position, $attributes);
        $this->makeTrade($position, -$attributes['amount'])->save();

        return $this;
    }

    /**
     * Make a Trade without persisting
     *
     * @param Position $position
     * @param $amount
     * @return mixed
     */
    private function makeTrade($position, $amount)
    {
        $position->update(['amount' => $position->amount + $amount]);
        $this->cash -= $amount * array_first($position->price());

        return $this;
    }

    /* --------------------------------------------
     * Functions for withdrawing or depositing cash
     * --------------------------------------------
     */

    /**
     * Deposit an amount of cash.
     *
     * @param array $attributes
     * @return $this
     */
    public function deposit($attributes)
    {
        $this->transaction->pay($attributes);

        $this->cash = $this->cash + $attributes['amount'];
        $this->save();
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
        $this->transaction->pay($attributes);

        $this->cash = $this->cash - $attributes['amount'];
        $this->save();
        return $this;
    }

    /**
     * Deduct fees from portfolio cash.
     *
     * @param array $attributes
     * @return Portfolio
     */
    public function fees($attributes)
    {
        $this->transaction->fees($attributes);

        $this->cash = $this->cash - $attributes['fees'];
        $this->save();

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


    public function lastTransactionDate()
    {
        return $this->transactions()->last()->executed_at;
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
