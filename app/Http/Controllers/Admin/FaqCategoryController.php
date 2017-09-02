<?php


namespace App\Http\Controllers\Admin;

use App\Entities\FaqType;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Illuminate\Http\Request;


class FaqCategoryController extends CrudController
{

    public function setup()
    {
        $this->crud->setModel(FaqType::class);
        $this->crud->setRoute('admin/faq-category');
        $this->crud->setEntityNameStrings('FAQ category', 'FAQ categories');


        $this->crud->setColumns([

            [
                'name'  => 'original_name',
                'label' => 'Category',
                'type'  => 'text',
            ],
            [
                'name'  => 'name_de',
                'label' => 'Category (de)',
                'type'  => 'text',
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