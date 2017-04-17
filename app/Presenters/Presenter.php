<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 17.04.17
 * Time: 17:08
 */

namespace App\Presenters;


abstract class Presenter
{

    public $entity;

    public function __construct($entity)
    {
        $this->entity = $entity;
    }

    public function __get($property)
    {
        if (method_exists($this, $property)) {

            return $this->$property();
        }


        return $this->entity->$property();
    }

    public function priceFormat()
    {
        return numfmt_create('de_DE', \NumberFormatter::CURRENCY);
    }
}