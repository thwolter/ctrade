<?php


namespace App\Http\Controllers\Admin;

use App\Entities\Exchange;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Illuminate\Http\Request;


class ExchangeCrudController extends CrudController
{

    public function setup()
    {
        $this->crud->setModel(Exchange::class);
        $this->crud->setRoute('admin/exchange');
        $this->crud->setEntityNameStrings('exchange', 'exchanges');

        $this->crud->setColumns([
            ['name'  => 'code', 'label' => 'Code'],
            ['name'  => 'name', 'label' => 'name'],
        ]);

        $this->crud->addField([
            'name'       => 'code',
            'label'      => 'Code',
            'type'       => 'text',
        ]);

        $this->crud->addField([
            'name'       => 'name',
            'label'      => 'Name',
            'type'       => 'text',
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