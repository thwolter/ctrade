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

        if ($this->isValid($attributes, $type)) {

            $limit->value = (float)array_get($attributes, $type.'_value');
            $limit->date = array_get($attributes, $type.'_date');
            $limit->active = 1;
            return $limit->save();

        } else {
            return false;
        }
    }


    /**
     * Check if a value for the specified type if provided and if date is not null if the
     * the date is provided for this type.
     *
     * @param array $attributes
     * @param string $type
     * @return bool
     */
    public function isValid($attributes, $type)
    {
        $date = array_get($attributes, $type.'_date');
        $value = array_get($attributes, $type.'_value');
        $missingDate = array_key_exists($type.'_date', $attributes) && is_null($date);

        return ($value !== null && !$missingDate);
    }

    /**
     * Inactivates the limit of a given type.
     *
     * @param string $type
     */
    public function inactivate($type)
    {
        $limit = $this->get($type);

        if ($limit) {
            $limit->update(['active' => 0]);
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
        return $this->portfolio->limits()->ofType($type)->first();
    }


    /**
     * Return true if the portfolio has an active limit of specified type or false otherwise.
     *
     * @param string $type
     * @return bool
     */
    public function active($type)
    {
        $limit = $this->get($type);
        return (is_null($limit)) ? false : $limit->active;
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
        foreach ($this->portfolio->limits()->active()->get() as $type) {
            $limit = $this->get($type->type->code)->value;
            $date = $this->get($type->type->code)->date;

            switch ($type->type->code) {
                case 'absolute':
                    $quota = $risk / $limit;
                    break;
                case 'relative':
                    $quota = $risk / ($limit * $this->portfolio->total() / 100);
                    break;
                case 'floor':
                    $quota = $risk / ($this->portfolio->total() - $limit);
                    break;
                case 'target':
                    $riskToTarget = $risks->portfolioRisk(Carbon::parse($date));
                    $quota = $riskToTarget / ($this->portfolio->total() - $limit);
                    break;
                default:
                    $quota = null;
            }
            $result[$type->type->code] = [
                'quota' => $quota,
                'risk' => $risk,
                'limit' => $limit,
                'date' => $date,
                'ccy' => $this->portfolio->currencyCode()
            ];
        };
        return $result;
    }
}