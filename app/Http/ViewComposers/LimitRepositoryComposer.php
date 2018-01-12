<?php

namespace App\Http\ViewComposers;

use App\Repositories\LimitRepository;
use Illuminate\View\View;

class LimitRepositoryComposer {

    protected $limitRepository;


    public function __construct(LimitRepository $limitRepository)
    {
        $this->limitRepository = $limitRepository;
    }


    public function compose(View $view)
    {
        $view->with('limitRepository', $this->limitRepository);
    }
}