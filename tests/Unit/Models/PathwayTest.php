<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Entities\Stock;
use App\Entities\Dataset;
use App\Models\Pathway;

class PathwayTest extends TestCase
{
    
    use DatabaseMigrations;
    
    
    public function test_can_assign_pathway()
    {
        $stock = Stock::saveWithParameter('Allianz', 'EUR', 'Industry');
        
        $pathway = Pathway::make('Quandl', 'SSE', 'ALV')->assign($stock);
    
        $this->assertTrue(Dataset::whereCode('ALV')->first()->hasProvider('Quandl'));  
            
        
    }
}
