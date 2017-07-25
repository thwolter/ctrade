<?php


namespace App\Classes;


use Carbon\Carbon;

class Helpers
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
}