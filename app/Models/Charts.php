<?php

namespace App\Models;

use Lava;

class Charts
{
    static public function history($summary)
    {
        $history = $summary['History'];

        $stocksTable = Lava::DataTable()
            ->addDateColumn('Day of Month')
            ->addNumberColumn('Projected');

        for ($i = 1; $i < count($history); $i++) {
            $stocksTable->addRow([$history[$i]['Date'], $history[$i]['Value']]);
        }

        Lava::AreaChart('HistoryChart', $stocksTable);

    }

    static public function riskchart($summary)
    {
        $VaR = $summary['Total'][0]['Value'];
        $value = $summary['Value'][0]['Value'];
        $max = max(
            0.05 * $value, $VaR);

        $risk = Lava::DataTable()
            ->addStringColumn('Type')
            ->addNumberColumn('Value')
            ->addRow(['Risiko', $VaR]);

        Lava::GaugeChart('Risk', $risk)
            ->setOptions([
                'width' => 200,
                'greenFrom' => 0,
                'greenTo' => 0.7 * $max,
                'yellowFrom' => 0.7 * $max,
                'yellowTo' => 0.9 * $max,
                'redFrom' => 0.9 * $max,
                'redTo' => $max,
                'max' => $max,
                'majorTicks' => [
                    'niedrig',
                    'hoch'
                ]
            ]);
    }

    static public function piechart($summary)
    {
        $contrib = Lava::DataTable()
            ->addStringColumn('Reasons')
            ->addNumberColumn('Percent');

        $total = $summary['Total'][0]['Value'];
        $values = $summary['Risks'];

        for ($i = 0; $i < count($values); $i++) {


            $contrib->addRow([
                $values[$i]['Name'],
                $values[$i]['Value']/$total
            ]);
        }


        Lava::PieChart('Contribution', $contrib, [
            'height' => 400,
            'title'  => 'Verteilung',
            'is3D'   => false,
        ]);
    }
}