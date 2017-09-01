<?php


namespace App\Http\Controllers\Admin;

use App\Entities\FaqType;
use App\Entities\Industry;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Illuminate\Http\Request;


class IndustryCrudController extends CrudController
{

    public function setup()
    {
        $this->crud->setModel(Industry::class);
        $this->crud->setRoute('admin/industry');
        $this->crud->setEntityNameStrings('industry', 'industries');


        $this->crud->setColumns([

            [
                'name'  => 'name',
                'label' => 'Name',
                'type'  => 'text',
            ],
            [
                'name'  => 'name_de',
                'label' => 'Name (de)',
                'type'  => 'text',
            ],

        ]);


        $this->crud->addField([
            'name'       => 'name',
            'label'      => 'Name (english)',
            'type'       => 'text',
            'attributes' => [
                'disabled' => 'disabled',
            ],
        ]);

        $this->crud->addField([
            'name'       => 'name_de',
            'label'      => 'Name (german)',
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