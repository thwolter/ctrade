<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 11.04.17
 * Time: 06:47
 */

namespace App\Repositories\Contracts;


interface RepositoryInterface
{
    public function all();

    public function create();

}