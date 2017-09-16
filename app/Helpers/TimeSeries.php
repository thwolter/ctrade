<?php


namespace App\Helpers;


use Carbon\Carbon;

class TimeSeries
{
    public function allWeekDays($date, $count)
    {
        $dates = array();
        $date = new Carbon($date);

        if ($date->isWeekday())
            $dates[] = $date->format('Y-m-d');

        while (count($dates) < $count)
        {
            $date->subWeekday(1);
            $dates[] = $date->format('Y-m-d');
        }
        return $dates;
    }

    public function allWeekDaysBetween($start, $end)
    {
        $dates = array();
        $date = new Carbon($end);

        if ($date->isWeekday())
            $dates[] = $date->format('Y-m-d');

        while ($date > $start)
        {
            $date->subWeekday(1);
            $dates[] = $date->format('Y-m-d');
        }

        if (last($dates) < $start)
            array_pop($dates);

        return $dates;
    }

    /**
     * Return all week days either within a period or as number up to set date.
     *
     * @param Request $request
     * @return array
     * @throws \Exception
     */
    public function getWeekDaysSeries($attributes)
    {
        if (isset($attributes['date']) && isset($attributes['count'])) {
            $days = TimeSeries::allWeekDays($attributes['date'], $attributes['count']);

        } elseif (isset($attributes['from']) && isset($attributes['to'])) {
            $days = TimeSeries::allWeekDaysBetween($attributes['from'], $attributes['to']);

        } else {
            throw new \Exception("Parameter ['date' and 'count'] or ['from' and 'to'] must be set.");
        }

        return $days;
    }
}