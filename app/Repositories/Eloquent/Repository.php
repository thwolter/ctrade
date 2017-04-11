<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 11.04.17
 * Time: 06:50
 */

namespace App\Repositories\Models;

use App\Repositories\Contracts\RepositoryInterface;
use App\Repositories\Exceptions\RepositoryException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Container\Container as App;

abstract class Repository implements RepositoryInterface {

    private $app;

    protected $model;

    public function __construct(App $app) {

        $this->app = $app;
        $this->makeModel();
    }

    abstract function model();

    public function makeModel() {

        $model = $this->app->make($this->model());

        if (!$model instanceof Model)
            throw new RepositoryException('Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\MOdel');

        return $this->model = $model;
    }

    public function all()
    {

        // TODO: Implement all() method.
    }

    public function create()
    {
        // TODO: Implement create() method.
    }
}