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
     * @return null|bool
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

            if ($limit->isDirty())
                return $limit->save();

        }
        return null;
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
     * @param $type
     * @return bool
     */
    public function inactivate($type)
    {
        $limit = $this->get($type);

        if (optional($limit)->isDirty())
            return $limit->update(['active' => 0]);

        return null;
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