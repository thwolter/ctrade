<?php

namespace App\Entities;

use App\Models\Pathway;
use App\Repositories\Financable;
use App\Repositories\FinanceRepository;
use Illuminate\Database\Eloquent\Model;

class CcyPair extends Model
{

    protected $fillable = ['origin', 'target'];


    public function datasets()
    {
        return $this->morphToMany(Dataset::class, 'datasetable')->withTimestamps();
    }


    public function pathway()
    {
        return Pathway::withDatasets($this->datasets);
    }
}
