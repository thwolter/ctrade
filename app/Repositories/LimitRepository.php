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
     * Deliver the time series of set limits for specified type till given date. The
     * length of the time series is specified with parameter count but cannot start
     * before the portfolio creation date.
     *
     * @param $type
     * @param $date
     * @param $count
     * @return array
     * @throws LimitException
     */
    public function limitHistory($type, $date, $count)
    {
        if (! LimitType::whereCode($type)->exists())
            throw new LimitException("Parameter 'type' doesn't exist");

        $limits = $this->portfolio->limits()->whereHas('type',
            function($query) use($type) {$query->whereCode($type); })->get();

        $history = $this->limitsArray($limits);

        $start = max($this->portfolio->created_at, Carbon::parse($date)->subDay($count));
        $days = array_reverse((new Helpers())->allWeekDaysBetween($start, $date));

        if (! array_key_exists($days[0], $history)) $history[$days[0]] = 0;
        for ($i = 0; $i < count($days); $i++)
        {
            if (! array_key_exists($days[$i], $history))
                $history[$days[$i]] = $history[$days[$i-1]];
        }

        ksort($history);
        return $history;
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
}