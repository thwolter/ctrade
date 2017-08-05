<?php


namespace App\Repositories;


use App\Classes\Helpers;
use App\Entities\Limit;
use App\Entities\LimitType;
use App\Entities\Portfolio;
use App\Notifications\LimitChanged;
use App\Repositories\Exceptions\LimitException;
use Carbon\Carbon;

class LimitRepository
{

    protected $portfolio;


    public function __construct(Portfolio $portfolio)
    {
        $this->portfolio = $portfolio;
    }


    /**
     * Create an array with date and limit value for all dates on which a limit was defined.
     *
     * @param  $limits
     * @return array
     */
    public function limitsArray($limits)
    {
        $result = [];
        foreach ($limits as $limit) {
            $value = $limit->toArray();
            $result[key($value)] = array_first($value);
        }
        return $result;
    }

    /**
     * Set a limit for the portfolio an specified limit type based on request array.
     *
     * @param string $type
     * @param array $attributes
     *
     * @return bool
     */
    public function set($type, array $attributes)
    {
        $limit = $this->get($type);

        if (is_null($limit)) {
            $limit = new Limit;
            $limit->portfolio()->associate($this->portfolio);
            $limit->type()->associate(LimitType::whereCode($type)->first());
        }

        $currentLimit = [$limit->value, $limit->date, $limit->active];

        $limit->value = array_get($attributes, $type.'_value');
        $limit->date = array_get($attributes, $type.'_date');
        $dateMissing = array_key_exists($type.'_date', $attributes) && is_null($limit->date);

        $limit->active = true;

        $newLimit = [$limit->value, $limit->date, $limit->active];

        if (!($limit->value > 0) || $dateMissing) {
            return false;

        } else {
            $saved = $limit->save();

            if ($saved && ($currentLimit != $newLimit)) {
                $this->portfolio->user->notify(new LimitChanged($limit));
            }

            return $saved;
        }
    }


    /**
     * Inactivates the limit of a given type.
     *
     * @param string $type
     */
    public function inactivate($type)
    {
        $limit = $this->get($type);

        if (! is_null($limit)) {

            $wasActive = $limit->getAttribute('active');
            $limit->active = false;
            $limit->save();

            if ($wasActive != $limit->active) {
                $this->portfolio->user->notify(new LimitChanged($limit));
            }
        }
    }


    /**
     * Return an instance of the limit for the portfolio and specified limit type.
     *
     * @param $type
     * @return Limit
     */
    public function get($type)
    {
        return $this->portfolio->limits()
            ->whereHas('type', function ($query) use ($type) {$query->whereCode($type);})
            ->first();
    }


    /**
     * Return true if the portfolo has an active limit of specified type or false otherwise.
     *
     * @param string $type
     * @return bool
     */
    public function active($type)
    {
        $limit = $this->get($type);
        return (is_null($limit)) ? false : $limit->active;
    }
}