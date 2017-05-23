<?php

namespace Tests\Unit\Models;

use App\Models\Exceptions\QuantModelException;
use App\Models\QuantModel;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class QuantModelTest extends TestCase
{
    /** @test */
    public function can_divide_array_with_one_entry()
    {
        $m = new QuantModel();
        $this->assertEquals([0.25], $m->divide([1], [4]));
    }

    /** @test */
    public function can_divide_array_with_two_entries()
    {
        $m = new QuantModel();
        $this->assertEquals([0.25, 0.5], $m->divide([1,3], [4,6]));
    }

    /**
     * @test
     */
    public function throws_an_error_for_different_vector_lengths()
    {
        $m = new QuantModel();

        $this->expectException(QuantModelException::class);
        $this->assertEquals([0.25, 0.5], $m->divide([1,3], [4]));
    }


    /** @test */
    public function cbind_combines_arrays_with_unique_dates()
    {
        $m = new QuantModel();

        $arr1 = ['2017-03-20' => 10, '2017-03-19' => 6];
        $arr2 = ['2017-03-20' => 5,  '2017-03-19' => 4];

        $res = [
            '2017-03-20' => [10, 5],
            '2017-03-19' => [6,  4]
        ];

        $this->assertEquals($res, $m->cbindArray($arr1, $arr2));
    }

    /** @test */
    public function cbind_combines_array_with_non_uniuqe_dates()
    {
        $m = new QuantModel();

        $arr1 = ['2017-03-20' => 10, '2017-03-19' => 6];
        $arr2 = ['2017-03-20' => 5,  '2017-03-18' => 4];

        $res = [
            '2017-03-20' => [10, 5],
        ];

        $this->assertEquals($res, $m->cbindArray($arr1, $arr2));
    }

    /** @test */
    public function divide_accepts_a_Date_column()
    {
        $m = new QuantModel();

        $arr1 = ['2017-03-20' => 10, '2017-03-19' => 6];
        $arr2 = ['2017-03-20' => 5,  '2017-03-19' => 4];

        $this->assertEquals(['2017-03-20' => 2, '2017-03-19' => 1.5], $m->divide($arr1, $arr2));

    }


}
