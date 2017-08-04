<?php


namespace App\Repositories;


use App\Classes\Helpers;
use App\Entities\Limit;
use App\Entities\LimitType;
use App\Entities\Portfolio;
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
     */
    public function set($type, array $attributes)
    {
        $limit = $this->get($type);

        if (is_null($limit)) {
            $limit = new Limit;
            $limit->portfolio()->associate($this->portfolio);
            $limit->type()->associate(LimitType::whereCode($type)->first());
        }

        $limit->value = array_get($attributes, $type.'_value');
        $limit->date = array_get($attributes, $type.'_date');
        $limit->active = true;

        $limit->save();
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
            $limit->active = false;
            $limit->save();
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