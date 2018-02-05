<?php

namespace Tests\Feature\Classes;

use App\Classes\TimeSeries;
use App\Exceptions\TimeSeriesException;
use Tests\TestCase;
use Tests\Traits\FakeHistoryTrait;

class TimeSeriesTest extends TestCase
{
    use FakeHistoryTrait;

    private $timeseries;


    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->timeseries = new TimeSeries($this->data, $this->columns);
    }

    /**
     * A basic test example.
     *
     * @return void
     * @throws TimeSeriesException
     */
    public function test_returns_available_columns()
    {
        $this->assertEquals($this->getOpen($this->data), $this->timeseries->getOpen());
        $this->assertEquals($this->getHigh($this->data), $this->timeseries->getHigh());
        $this->assertEquals($this->getLow($this->data), $this->timeseries->getLow());
        $this->assertEquals($this->getClose($this->data), $this->timeseries->getClose());

        $this->assertEquals($this->getOpen($this->data), $this->timeseries->column('Open')->get());
        $this->assertEquals($this->getHigh($this->data), $this->timeseries->column('High')->get());
        $this->assertEquals($this->getLow($this->data), $this->timeseries->column('Low')->get());
        $this->assertEquals($this->getClose($this->data), $this->timeseries->column('Close')->get());
    }


    /**
     * @throws TimeSeriesException
     */
    public function test_throw_error_if_multidimensional_and_no_filter()
    {
        $this->expectException(TimeSeriesException::class);
        $this->timeseries->get();
    }


    public function test_throw_exception_when_fill_without_from_and_to()
    {
        $this->expectException(TimeSeriesException::class);
        $this->timeseries->fill()->getClose();

    }

    public function test_fill_array_with_previous_day_values()
    {
        $this->assertEquals($this->getClose($this->dataFilled),
            $this->timeseries->from('2017-12-22')->to('2017-12-29')->fill()->getClose()
        );

         $this->assertEquals($this->getClose($this->dataFilledFrom26),
            $this->timeseries->from('2017-12-26')->to('2017-12-29')->fill()->getClose()
        );
    }

    public function test_fill_array_with_out_of_range_from_throws_exception()
    {
        $this->expectException(TimeSeriesException::class);
        $this->timeseries->from('2017-11-26')->to('2017-12-29')->fill()->getClose();
    }


    public function test_returned_array_is_sorted()
    {
        $timeseries = new TimeSeries($this->dataUnsorted, $this->columns);

        $this->assertEquals($this->getClose($this->data), $timeseries->getClose());
    }


    public function test_return_data_in_reverse_order()
    {
        $this->assertEquals($this->getClose($this->data), $this->timeseries->reverse()->getClose());
    }


    public function test_returned_data_are_counted()
    {
        $close = array_slice($this->getClose($this->data), 0, 1);
        $this->assertEquals($close, $this->timeseries->count(1)->getClose());

        $close = array_slice($this->getClose($this->data), 0, 3);
        $this->assertEquals($close, $this->timeseries->count(3)->getClose());

        $close = array_slice($this->getClose($this->data), 0, 5);
        $this->assertEquals($close, $this->timeseries->count(5)->getClose());

    }

    public function test_return_an_empty_array_if_count_exceeds_available_data()
    {
        $this->assertEquals([], $this->timeseries->count(100)->getClose());
    }


    public function test_returned_data_are_limited()
    {
        $close = array_slice($this->getClose($this->data), 0, 1);
        $this->assertEquals($close, $this->timeseries->limit(1)->getClose());

        $close = array_slice($this->getClose($this->data), 0, 3);
        $this->assertEquals($close, $this->timeseries->limit(3)->getClose());
    }


    public function test_return_array_even_if_limit_exceeds_available_data()
    {
        $this->assertEquals($this->getClose($this->data), $this->timeseries->limit(100)->getClose());
    }


    public function test_returns_the_reverse_ordered_data()
    {
        $this->assertEquals($this->getClose($this->dataReverseOrder), $this->timeseries->reverse()->getClose());
    }

    public function test_returns_the_latest_and_oldest_value()
    {
        $this->assertEquals($this->getClose($this->dataLatest), $this->timeseries->getLatestClose());
        $this->assertEquals($this->getClose($this->dataOldest), $this->timeseries->getOldestClose());
    }


    public function test_throw_exception_if_not_available_column_requested()
    {
        $this->expectException(TimeSeriesException::class);
        $this->timeseries->getVolume();
    }


    public function test_throw_exception_if_not_available_property_requested()
    {
        $this->expectException(TimeSeriesException::class);
        $this->timeseries->findNemo();
    }


    public function test_return_data_starting_from_a_specified_date()
    {
        $this->assertEquals($this->getClose($this->dataFrom27),
            $this->timeseries->from('2017-12-27')->getClose());
    }


    public function test_return_data_ends_to_a_specified_date()
    {
        $this->assertEquals($this->getClose($this->dataTo27),
            $this->timeseries->to('2017-12-27')->getClose());
    }


    public function test_returns_only_weekdays()
    {
        $this->assertEquals($this->getClose($this->dataOnlyWeekdays),
            $this->timeseries->weekdays()->getClose());
    }


    /**
     * @throws TimeSeriesException
     */
    public function test_returns_an_associative_array()
    {
        $this->assertEquals($this->dataAssocArray, $this->timeseries->asAssocArray()->get());
        $this->assertEquals($this->dataAssocArrayClose, $this->timeseries->asAssocArray()->getClose());
    }

    public function test_get_the_number_of_data_rows()
    {
        $this->assertEquals(count($this->data), $this->timeseries->count());
    }

    public function test_can_return_reciprocal_values()
    {
        $this->assertEquals($this->getClose($this->dataReciprocal),
            $this->timeseries->reciprocal()->getClose()
        );
    }
}
