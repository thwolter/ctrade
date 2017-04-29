<?php

namespace App\Models;

use Lava;

class Charts
{
    static public function LineChart($data)
    {
        $stocksTable = Lava::DataTable();

        $stocksTable->addDateColumn('Day of Month')
            ->addNumberColumn('Projected')
            ->addNumberColumn('Official');


        for ($i = 1; $i < count($data); $i++) {
            $stocksTable->addRow([$data[$i]['Date'], $data[$i]['Value']]);
        }

        Lava::LineChart('MyStocks', $stocksTable);

    }

    static public function gaugeChart()
    {
        $temps  = Lava::DataTable();

        $temps->addStringColumn('Type')
            ->addNumberColumn('Value')
            ->addRow(array('CPU', rand(0,100)))
            ->addRow(array('Case', rand(0,100)))
            ->addRow(array('Graphics', rand(0,100)));

        Lava::GaugeChart('Temps', $temps)
            ->setOptions([
                //'datatable' => $temps,
                'width' => 400,
                'greenFrom' => 0,
                'greenTo' => 69,
                'yellowFrom' => 70,
                'yellowTo' => 89,
                'redFrom' => 90,
                'redTo' => 100,
                'majorTicks' => [
                    'Safe',
                    'Critical'
                ]
            ]);
    }
}