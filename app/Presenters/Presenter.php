<?php


namespace App\Presenters;

use Carbon\Carbon;
use Prophecy\Exception\Doubler\MethodNotFoundException;
use Symfony\Component\Debug\Exception\UndefinedMethodException;


abstract class Presenter
{

    public $entity;

    protected $metric;

    protected $metricService;

    protected $replace = '/[^0-9,"."]/';

    private $priceFormat;



    public function __construct($entity)
    {
        $this->entity = $entity;

        $this->metrics = app('MetricService', [$entity]);
    }


    /**
     * @param $property
     * @return mixed
     * @throws \Exception
     */
    public function __get($property)
    {
        if (method_exists($this, $property)) {
            return $this->$property();
        }

        if (method_exists($this->entity, $property)) {
            return $this->entity->$property();

        } else {
            $class = get_class($this->entity);
            throw new \Exception("Method '{$property}' not found in {$class}");
        }
    }


    public function formatPrice($value, $format = [])
    {
        $currencyCode = array_get($format, 'currency', $this->entity->currency->code);

        $value = is_array($value) ? array_first($value) : $value;

        return ($value || array_get($format, 'showNull'))
            ? $this->priceFormatter()->formatCurrency($value, $currencyCode)
            : array_get($format, 'nullString', null);
    }


    public function formatPercentage($value, $decimal = 1)
    {
        return sprintf("%01.{$decimal}f %%", 100 * $value);
    }



    public function formatDate($date)
    {
        if ($date) {
            return Carbon::parse($date)->formatLocalized('%d.%m.%Y');
        }
    }


    private function priceFormatter()
    {
        if (!$this->priceFormat) {
            $this->priceFormat = new \NumberFormatter('de_DE', \NumberFormatter::CURRENCY);
        }

        return $this->priceFormat;
    }
}