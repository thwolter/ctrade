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

        $this->crud->setColumns([
            ['name' => 'isin', 'label' => 'ISIN'],
            ['name' => 'wkn', 'label' => 'WKN'],
            ['name' => 'name', 'label' => 'Name'],
            ['name' => 'checked', 'label' => 'Checked'],
        ]);

        $this->crud->addFilter([
            'type' => 'simple',
            'name' => 'checked',
            'label' => 'Not checked'
        ],
            false,
            function () {
                $this->crud->addClause('where', 'checked', 0);
            });


        $this->crud->addField([
            'name' => 'name',
            'label' => 'Name',
            'type' => 'text',
        ]);

        $this->crud->addField([
            'name' => 'proposed_name',
            'label' => 'Proposal',
            'type' => 'text',
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

        $this->crud->addField([
            'name' => 'checked',
            'label' => 'Checked',
            'type' => 'checkbox'
        ]);


    }

    public function store(Request $request)
    {
        return parent::storeCrud();
    }

    public function update(Request $request)
    {
        if ($request->get('checked')) {
            //$request->request->set('checked', 1);
            $request->request->set('checked_at', Carbon::now());
            $request->request->set('checked_by', $request->user()->id);

        } else {
            //$request->request->set('checked', 0);
            $request->request->set('checked_at', null);
            $request->request->set('checked_by', null);
        }
        return parent::updateCrud();
    }

}