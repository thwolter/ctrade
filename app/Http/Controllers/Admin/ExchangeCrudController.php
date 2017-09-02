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
            ['name'  => 'original_name', 'label' => 'Name'],
            ['name'  => 'name_de', 'label' => 'Name (de)'],
        ]);

        $this->crud->addField([
            'name'       => 'code',
            'label'      => 'Code',
            'type'       => 'text',
            'attributes' => [
                'disabled' => 'disabled',
            ],
        ]);

        $this->crud->addField([
            'name'       => 'original_name',
            'label'      => 'Name (english)',
            'type'       => 'text',
        ]);

        $this->crud->addField([
            'name'       => 'name_de',
            'label'      => 'Name (german)',
            'type'       => 'text',
        ]);


    }

    public function store(Request $request)
    {
        $this->amendRequest($request);
        return parent::storeCrud();
    }

    public function update(Request $request)
    {
        $this->amendRequest($request);
        return parent::updateCrud();
    }

    /**
     * Replace a model accessor field by the original field.
     *
     * @param Request $request
     */
    private function amendRequest(Request $request): void
    {
        $request->merge(['name' => $request->get('original_name')]);
    }

}