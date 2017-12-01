<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 17.04.17
 * Time: 16:41
 */

namespace App\Services;


use App\Exceptions\MetricsException;

trait Metricsable
{

    /**
     * The instance of the presenter.
     *
     * @var $metricsInstance
     */
    private $metricsInstance;


    public function metrics()
    {
        if (!$this->metrics or !class_exists($this->metrics)) {
            throw new MetricsException("'service' property not defined.");
        }

        if (!isset($this->metricsInstance)) {
            $this->metricsInstance = new $this->metrics($this);
        }

        return $this->metricsInstance;
    }
}