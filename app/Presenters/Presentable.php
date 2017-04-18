<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 17.04.17
 * Time: 16:41
 */

namespace App\Presenters;


use App\Presenters\Exceptions\PresenterException;

trait Presentable
{

    protected $presenterInstance;


    public function present()
    {

        if (!$this->presenter or !class_exists($this->presenter)) {

            throw new PresenterException("'presenter' property not defined.");
        }


        if (!isset($this->presenterInstance)) {

            $this->presenterInstance = new $this->presenter($this);
        }


        return $this->presenterInstance;

    }
}