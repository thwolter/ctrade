<?php

namespace Tests;

use App\Entities\Portfolio;
use App\Entities\Position;
use App\Entities\Stock;
use App\Entities\Currency;
use App\Repositories\Metadata\QuandlECB;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Storage;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function tempDirectoroy() {
        
        $tmpdir = 'tmp/'.uniqid();
        Storage::makeDirectory($tmpdir);

        return $tmpdir;
    }

    public function validateDate($date)
    {
        if (is_null($date)) return false;
        $d = \Carbon\Carbon::createFromFormat('Y-m-d', $date);
        return $d && $d->format('Y-m-d') === $date;
    }
}
