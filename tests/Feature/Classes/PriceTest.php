<?php

namespace Tests\Feature\Classes;

use App\Classes\Output\Price;
use App\Exceptions\OutputException;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PriceTest extends TestCase
{
    private $price;


    protected function setUp()
    {
        parent::setUp();
        $this->price = new Price('2017-12-22', 20, 'EUR');
    }


    public function test_static_make_returns_price()
    {
        $this->assertEquals($this->price, Price::make('2017-12-22', 20, 'EUR'));
    }


    public function test_static_fromArray_returns_price()
    {
        $this->assertEquals($this->price, Price::fromArray(['2017-12-22' => 20], 'EUR'));
    }


    public function test_formatValue_returns_formatted_string()
    {
        $this->assertEquals('20,00 €', $this->price->formatValue());
        $this->assertEquals('20,00 €', $this->price->formatValue(2));

        $this->assertEquals('20,0 €', $this->price->formatValue(1));
        $this->assertEquals('20 €', $this->price->formatValue(0));
    }


    public function test_throw_excemption_for_digits_larger_2()
    {
        $this->expectException(OutputException::class);
        $this->price->formatValue(3);
    }


    public function test_convert_to_string_when_required()
    {
        $this->assertEquals('20,00 €', (string)$this->price);
    }
}
