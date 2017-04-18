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

    protected static $presenterInstance;



    public function present() {

        if (!$this->presenter or !class_exists($this->presenter)) {

            throw new PresenterException("'presenter' property not defined.");
        }


        if (!isset(static::$presenterInstance)) {

            static::$presenterInstance = new $this->presenter($this);
        }


        return static::$presenterInstance;



        //return new $this->presenter($this);
    }
}