<?php


namespace App\Repositories;


use App\Entities\Portfolio;
use App\Services\Metrics\PortfolioMetricService;
use Carbon\Carbon;

class LimitRepository
{

    protected $portfolio;

    protected $metrics;


    public function __construct(Portfolio $portfolio)
    {
        $this->portfolio = $portfolio;

        $this->metrics = app()->make(PortfolioMetricService::class);
    }


    /**
     * Return the utilisation for each limit.
     *
     * @return array
     */
    public function utilisation()
    {
        $risk = $this->metrics->risk($this->portfolio);

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
                    $riskToTarget = $this->metrics->riskToDate($this->portfolio, Carbon::parse($limit->date));
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