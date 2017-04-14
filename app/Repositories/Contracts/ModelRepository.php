<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 14.04.17
 * Time: 07:38
 */

namespace App\Repositories\Contracts;


interface ModelRepository
{
    function firstOrCreate(array $attributes, array $joining = [], $touch = true);
}