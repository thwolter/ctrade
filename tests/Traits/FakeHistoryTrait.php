<?php

namespace Tests\Traits;


trait FakeHistoryTrait
{
    protected $dataUnsorted = [
        ['2017-12-27', null, 68, 60, 68],
        ['2017-12-28', null, 69, 60, 65],
        ['2017-12-22', null, 66, 60, 60],
        ['2017-12-23', null, 67, 60, 63],
        ['2017-12-29', null, 70, 60, 70],
    ];
    protected $data = [
        ['2017-12-29', null, 70, 60, 70],
        ['2017-12-28', null, 69, 60, 65],
        ['2017-12-27', null, 68, 60, 68],
        ['2017-12-23', null, 67, 60, 63],
        ['2017-12-22', null, 66, 60, 60],
    ];
    protected $columns = [
        'Date',
        'Open',
        'High',
        'Low',
        'Close'
    ];
    protected $dataAssocArray = [
        '2017-12-29' => ['Open' => null, 'High' => 70, 'Low' => 60, 'Close' => 70],
        '2017-12-28' => ['Open' => null, 'High' => 69, 'Low' => 60, 'Close' => 65],
        '2017-12-27' => ['Open' => null, 'High' => 68, 'Low' => 60, 'Close' => 68],
        '2017-12-23' => ['Open' => null, 'High' => 67, 'Low' => 60, 'Close' => 63],
        '2017-12-22' => ['Open' => null, 'High' => 66, 'Low' => 60, 'Close' => 60],
    ];
    protected $dataFilled = [
        ['2017-12-29', null, 70, 60, 70],
        ['2017-12-28', null, 69, 60, 65],
        ['2017-12-27', null, 68, 60, 68],
        ['2017-12-26', null, 67, 60, 63],
        ['2017-12-25', null, 67, 60, 63],
        ['2017-12-24', null, 67, 60, 63],
        ['2017-12-23', null, 67, 60, 63],
        ['2017-12-22', null, 66, 60, 60],
    ];
    protected $dataReverseOrder = [

    ];

    /**
     * @return array
     */
    protected function getClose($data)
    {
        return $this->getAssocArray($data, 4);
    }

    /**
     * @param $column
     * @return array
     */
    protected function getAssocArray($array, $column)
    {
        $keys = array_column($array, 0);
        $values = array_column($array, $column);

        return array_combine($keys, $values);
    }

    /**
     * @return array
     */
    protected function getOpen($data)
    {
        return $this->getAssocArray($data, 1);
    }

    /**
     * @return array
     */
    protected function getHigh($data)
    {
        return $this->getAssocArray($data, 2);
    }

    /**
     * @return array
     */
    protected function getLow($data)
    {
        return $this->getAssocArray($data, 3);
    }
}