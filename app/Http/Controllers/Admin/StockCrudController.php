<?php


namespace App\Http\Controllers\Admin;

use App\Entities\Currency;
use App\Entities\Industry;
use App\Entities\Sector;
use App\Entities\Stock;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Carbon\Carbon;
use Illuminate\Http\Request;


class StockCrudController extends CrudController
{

    public function setup()
    {
        $this->crud->setModel(Stock::class);
        $this->crud->setRoute('admin/stocks');
        $this->crud->setEntityNameStrings('stock', 'stocks');
        $this->crud->enableAjaxTable();
        $this->crud->allowAccess('revisions');
        $this->crud->with('revisionHistory');

        $this->crud->setColumns([
            [
                'name' => 'isin',
                'label' => 'ISIN'
            ],
            [
                'name' => 'wkn',
                'label' => 'WKN'
            ],
            [
                'label' => 'Name',
                'type' => 'model_function',
                'function_name' => 'getOriginalName'
            ],
            [
                'name' => 'name_overwrite',
                'label' => 'Overwritten'
            ],
            [
                'label' => 'Currency',
                'type' => 'select',
                'name' => 'currency_id',
                'entity' => 'currency',
                'attribute' => 'code',
                'model' => Currency::class
            ]
        ]);

        $this->crud->addFilter([
            'type' => 'simple',
            'name' => 'name_overwrite',
            'label' => 'Overwritten'
        ],
            false,
            function () {
                $this->crud->addClause('overwritten');
            });


        $this->crud->addFilter([
            'type' => 'simple',
            'name' => 'industry',
            'label' => 'Empty'
        ],
            false,
            function () {
                $this->crud->addClause('where', 'industry_id', null);
            });


        $this->crud->addFilter([
            'name' => 'currency',
            'type' => 'dropdown',
            'label'=> 'Currency'
        ], function() {
                return Currency::getEnumValuesAsAssociativeArray('code');
        }, function($value) { // if the filter is active
            $this->crud->addClause('where', 'currency_id', $value);
        });

        $this->crud->addFilter([
            'name' => 'industry',
            'type' => 'dropdown',
            'label'=> 'Industry'
        ], function() {
            return Industry::getEnumValuesAsAssociativeArray('name');
        }, function($value) { // if the filter is active
            $this->crud->addClause('where', 'industry_id', $value);
        });

        $this->crud->addFilter([
            'name' => 'sector',
            'type' => 'dropdown',
            'label'=> 'Sector'
        ], function() {
            return Sector::getEnumValuesAsAssociativeArray('name');
        }, function($value) { // if the filter is active
            $this->crud->addClause('where', 'industry_id', $value);
        });


        $this->crud->addField([
            'name' => 'name_overwrite',
            'label' => 'Overwritten Name',
            'type' => 'text'
        ]);

        $this->crud->addField([
            'name' => 'sector_id',
            'label' => 'Sector',
            'entity' => 'sector',
            'model' => Sector::class,
            'attribute' => 'name',
            'type' => 'select',
        ]);

        $this->crud->addField([
            'name' => 'industry_id',
            'label' => 'Industry',
            'entity' => 'industry',
            'model' => Industry::class,
            'attribute' => 'name',
            'type' => 'select',
        ]);

        $this->crud->addField([
            'name' => 'isin',
            'label' => 'ISIN',
            'type' => 'text',
            'attributes' => [
                'disabled' => 'disabled',
            ],
        ]);

        $this->crud->addField([
            'name' => 'wkn',
            'label' => 'WKN',
            'type' => 'text',
            'attributes' => [
                'disabled' => 'disabled',
            ],
        ]);

        $this->crud->addField([
            'name' => 'currency_id',
            'label' => 'Currency',
            'entity' => 'currency',
            'model' => Currency::class,
            'attribute' => 'code',
            'type' => 'select',
            'attributes' => [
                'disabled' => 'disabled',
            ],
        ]);

    }

    public function store(Request $request)
    {
        return parent::storeCrud();
    }

    public function update(Request $request)
    {
        return parent::updateCrud();
    }

}