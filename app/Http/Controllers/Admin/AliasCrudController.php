<?php


namespace App\Http\Controllers\Admin;

use App\Entities\Alias;
use App\Entities\Exchange;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Illuminate\Http\Request;


class AliasCrudController extends CrudController
{

    public function setup()
    {
        $this->crud->setModel(Alias::class);
        $this->crud->setRoute('admin/alias');
        $this->crud->setEntityNameStrings('alias', 'aliases');

        $this->crud->setColumns([
            ['name'  => 'alias', 'label' => 'Alias'],
        ]);

        $this->crud->addField([
            'name'       => 'alias',
            'label'      => 'Alias',
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