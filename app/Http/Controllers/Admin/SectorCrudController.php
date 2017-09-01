<?php


namespace App\Http\Controllers\Admin;

use App\Entities\FaqType;
use App\Entities\Industry;
use App\Entities\Sector;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Illuminate\Http\Request;


class SectorCrudController extends CrudController
{

    public function setup()
    {
        $this->crud->setModel(Sector::class);
        $this->crud->setRoute('admin/sector');
        $this->crud->setEntityNameStrings('sector', 'sectors');


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