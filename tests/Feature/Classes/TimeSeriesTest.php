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
        $this->assertArraySubset($this->getOpen($this->data), $this->timeseries->getOpen());
        $this->assertArraySubset($this->getHigh($this->data), $this->timeseries->getHigh());
        $this->assertArraySubset($this->getLow($this->data), $this->timeseries->getLow());
        $this->assertArraySubset($this->getClose($this->data), $this->timeseries->getClose());

        $this->assertArraySubset($this->getOpen($this->data), $this->timeseries->column('Open')->get());
        $this->assertArraySubset($this->getHigh($this->data), $this->timeseries->column('High')->get());
        $this->assertArraySubset($this->getLow($this->data), $this->timeseries->column('Low')->get());
        $this->assertArraySubset($this->getClose($this->data), $this->timeseries->column('Close')->get());
    }


    /**
     * @throws TimeSeriesException
     */
    public function test_throw_error_if_multidimensional_and_no_filter()
    {
        $this->expectException(TimeSeriesException::class);
        $this->timeseries->get();
    }


    public function test_fill_array_with_previous_day_values()
    {
        $this->assertArraySubset($this->timeseries->fill('')->getClose(), $this->getAssocArray($this->dataFilled, 4));
    }


    public function test_returned_array_is_sorted()
    {
        $timeseries = new TimeSeries($this->dataUnsorted, $this->columns);

        $this->assertArraySubset($this->getClose($this->data), $timeseries->getClose());
    }


    public function test_return_data_in_reverse_order()
    {
        $this->assertArraySubset($this->getClose($this->data), $this->timeseries->reverse()->getClose());
    }


    public function test_returned_data_are_counted()
    {
        $close = array_slice($this->getClose($this->data), 0, 1);
        $this->assertArraySubset($close, $this->timeseries->count(1)->getClose());

        $close = array_slice($this->getClose($this->data), 0, 3);
        $this->assertArraySubset($close, $this->timeseries->count(3)->getClose());

        $close = array_slice($this->getClose($this->data), 0, 5);
        $this->assertArraySubset($close, $this->timeseries->count(5)->getClose());

    }

    public function test_return_an_empty_array_if_count_exceeds_available_data()
    {
        $this->assertArraySubset([], $this->timeseries->count(100)->getClose());
    }


    public function test_returned_data_are_limited()
    {
        $close = array_slice($this->getClose($this->data), 0, 1);
        $this->assertArraySubset($close, $this->timeseries->limit(1)->getClose());

        $close = array_slice($this->getClose($this->data), 0, 3);
        $this->assertArraySubset($close, $this->timeseries->limit(3)->getClose());
    }


    public function test_return_array_even_if_limit_exceeds_available_data()
    {
        $this->assertArraySubset($this->getClose($this->data), $this->timeseries->limit(100)->getClose());
    }


    public function test_returns_the_latest_and_oldest_value()
    {
        $latest = array_slice($this->getClose($this->data), 0, 1);
        $oldest = array_slice($this->getClose($this->dataReverseOrder), 0, 1);

        $this->assertArraySubset($latest, $this->timeseries->getLatestClose());
        $this->assertArraySubset($oldest, $this->timeseries->getOldestClose());
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


    /*  public function test_returns_an_assoc_array_with_all_data()
      {
          $timeseries = new TimeSeries($this->data, $this->columns);
          $this->assertArraySubset($this->dataAssocArray, $timeseries->get());

      }*/

    private function getDataAsAssocArray()
    {
        $keys = array_column($this->data, 0);
        $array = [];

        foreach ($this->data as $row) {
            $array[] = array_combine($this->columns, $row);
        }

        return array_combine($keys, $array);

    }


}
