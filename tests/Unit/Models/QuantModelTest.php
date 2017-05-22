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
}
