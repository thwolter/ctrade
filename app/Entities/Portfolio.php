<?php

namespace App\Entities;

use App\Entities\Traits\UuidModel;
use App\Events\PortfolioHasChanged;
use App\Presenters\Presentable;
use App\Repositories\PositionRepository;
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


    /**
     * A buy transaction for position with a given id.
     *
     * @param int $id the position id
     * @param float $amount the transaction's amount
     * @return Portfolio
     */
    public function buy($id, $amount)
    {
        $this->makeTrade($id, $amount)->save();
        return $this;
    }


    /**
     * A sell transaction for position with a given id
     *
     * @param $id
     * @param $amount
     * @return mixed
     */
    public function sell($id, $amount)
    {
        $this->makeTrade($id, -$amount)->save();
        return $this;
    }


    /**
     * Deposit an amount of cash.
     *
     * @param int $amount
     * @return $this
     */
    public function deposit($amount)
    {
        $this->cash = $this->cash + $amount;
        $this->save();
        return $this;
    }

    /**
     * Withdraw an amount of cash.
     *
     * @param int $amount
     * @return $this
     */
    public function withdraw($amount)
    {
        $this->cash = $this->cash - $amount;
        $this->save();
        return $this;
    }


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



    /*
     * private functions
     */

    /**
     * Make a Trade without persisting
     *
     * @param int $id of position
     * @param $amount
     * @return mixed
     */
    private function makeTrade($id, $amount)
    {
        $position = Position::find($id);
        $portfolio = $position->portfolio;

        $position->update(['amount' => $position->amount + $amount]);
        $portfolio->cash = $portfolio->cash - $amount * array_first($position->price());

        return $portfolio;
    }


    public function sluggable()
    {
        return ['slug' => ['source' => 'name']];
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
