<?php


namespace App\Repositories;


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
     * Return the utilisation for each limit.
     *
     * @return array
     */
    public function utilisation()
    {
        $risks = new RiskRepository($this->portfolio);
        $risk = $risks->portfolioRisk();

        $result = [];
        foreach ($this->portfolio->limits as $limit) {

            switch ($limit->type) {
                case 'absolute':
                    $quota = 1;
//                    $quota = $risk / $limit->value;
                    break;
                case 'relative':
                    $quota = 1;
//                    $quota = $risk / ($limit->value * $this->portfolio->total() / 100);
                    break;
                case 'floor':
                    $quota = 1;
//                    $quota = $risk / ($this->portfolio->total() - $limit->value);
                    break;
                case 'target':
                    $quota = 1;
                    $riskToTarget = $risks->portfolioRisk(Carbon::parse($limit->date));
//                    $quota = $riskToTarget / ($this->portfolio->total() - $limit->value);
                    break;
                default:
                    $quota = null;
            }
            $key = $limit->type;
            $result[$key] = [
                'quota' => $quota,
                'risk' => $risk,
                'limit' => $limit->value,
                'date' => $limit->date,
                'ccy' => $this->portfolio->currency->code
            ];
        };
        return $result;
    }
}