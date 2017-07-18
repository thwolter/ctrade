<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 18.07.17
 * Time: 16:37
 */

namespace App\Observers;


use App\Entities\Keyfigure;
use App\Entities\KeyfigureType;
use App\Entities\Portfolio;

class PortfolioObserver
{

    protected $keyfigures = [
        ['code' => 'risk', 'name' => 'Value at Risk'],
        ['code' => 'contribution', 'name' => 'Risk contribution']
    ];

    public function created(Portfolio $portfolio)
    {
        foreach ($this->keyfigures as $figure)
        {
            $this->assignKeyFigure($portfolio, $figure['code'], $figure['name']);
        }
    }

    private function assignKeyFigure($portfolio, $code, $name)
    {
        $type = KeyfigureType::firstOrCreate(['code' => $code, 'name' => $name]);
        $keyFigure = new Keyfigure();

        $keyFigure->type()->associate($type)->portfolio()->associate($portfolio)->save();

        return $keyFigure;
    }
}