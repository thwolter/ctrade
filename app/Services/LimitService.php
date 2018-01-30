<?php


namespace App\Services;

use App\Classes\Limits\LimitEnhancer;
use App\Classes\Output\Percent;
use App\Classes\Output\Price;


class LimitService
{
    use LimitEnhancer;

    public function breached($limit)
    {
        return $this->utilisation($limit)->getValue() > 1;
    }

    /**
     * @param $limit
     * @return Price|Percent
     */
    public function utilisation($limit)
    {
        return $this->enhance($limit)->utilisation();
    }

    /**
     * @param $limit
     * @return Price|Percent
     */
    public function value($limit)
    {
        return $this->enhance($limit)->value();
    }

}
