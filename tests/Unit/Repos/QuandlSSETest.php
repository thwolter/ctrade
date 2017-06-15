<?php

namespace Tests\Unit\Repos;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Repositories\Metadata\QuandlSSE;

class QuandlSSETest extends TestCase
{
    
    protected $json = '{"id":34944486,"dataset_code":"CCP","database_code":"SSE","name":"CELTIC STOCK WKN 905326 | ISIN GB0004339189 (CCP) - Stuttgart","description":"Stock Prices for Celtic Stock WKN 905326 | ISIN GB0004339189 from the Boerse Stuttgart. Currency:EUR; Sector: Media\/Entertainment\/Recreation - Tourism & Leisure","refreshed_at":"2017-06-14T21:33:17.454Z","newest_available_date":"2017-06-14","oldest_available_date":"2017-03-06","column_names":["Date","High","Low","Last","Previous Day Price","Volume"],"frequency":"daily","type":"Time Series","premium":false,"database_id":7330}';
    
    protected $item;
    protected $repo;
    
    
    public function setUp()
    {
        $this->item = json_decode($this->json, true);
        $this->repo = new QuandlSSE();
    }
    
    /** @test */
    public function receive_wkn()
    {
        $this->assertEquals('905326', $this->repo->wkn($this->item));
    }
    
    /** @test */
    public function receive_isin()
    {
        $this->assertEquals('GB0004339189', $this->repo->isin($this->item));
    }
    
    /** @test */
    public function receive_currency()
    {
        $this->assertEquals('EUR', $this->repo->currency($this->item));
    }
    
    /** @test */
    public function receive_symbol()
    {
        $this->assertEquals('CCP', $this->repo->symbol($this->item));
    }
    
    /** @test */
    public function receive_name()
    {
        $this->assertEquals('CELTIC STOCK', $this->repo->name($this->item));
    }
    
    /** @test */
    public function receive_sector()
    {
        $this->assertEquals('Media/Entertainment/Recreation', $this->repo->sector($this->item));
    }
    
    /** @test */
    public function receive_industry()
    {
        $this->assertEquals('Tourism & Leisure', $this->repo->industry($this->item));
    }
    
    
}
