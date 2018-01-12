<?php


namespace App\Classes\Limits;


use App\Entities\Limit;

trait LimitEnhancer
{

    /**
     * Return the limit with additional functions for the specific limit type.
     *
     * @param Limit $limit
     * @return AbstractLimit
     */
    protected function enhance(Limit $limit)
    {
        return app(AbstractLimit::class, [$limit]);
    }
}