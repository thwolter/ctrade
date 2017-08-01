<?php


namespace App\Repositories;


use App\Classes\Helpers;
use App\Entities\Portfolio;
use App\Repositories\Exceptions\LimitException;

class LimitRepository
{

    protected $portfolio;


    public function __construct(Portfolio $portfolio)
    {
        $this->portfolio = $portfolio;
    }


    public function limitHistory($type, $date, $count)
    {
        $types = ['absolute', 'relative'];

        if (! in_array($type, $types)) {
            $error = sprintf("Parameter 'type' must be one of: %s.", implode($types, ', '));
            throw new LimitException($error);
        }

        $days = (new Helpers())->allWeekDays($date, $count);

        $result = [];
        foreach ($this->portfolio->limits as $limit)
        {
            $value = $limit->toArray();
            $result[key($value)] = array_first($value);
        }

        if (! $result[$days[0]]) $result[$days[0]] = 0;
        for ($i = 0; $i < count($days); $i++)
        {
            if (! $result[$days[$i]]) {
                $result[$days[$i]] = $result[$days[$i-1]];
            }
        }
        return $result;
    }
}