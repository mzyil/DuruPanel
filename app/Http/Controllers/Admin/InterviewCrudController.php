<?php

namespace App\Http\Controllers\Admin;

use App\Models\Customer;
use App\Models\Interview;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\InterviewRequest as StoreRequest;
use App\Http\Requests\InterviewRequest as UpdateRequest;
use Illuminate\Http\Request;

class InterviewCrudController extends CrudController
{

    public function setUp()
    {

        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
        $this->crud->setModel("App\Models\Interview");
        $this->crud->setRoute("admin/interview");
        $this->crud->setEntityNameStrings('Görüşme', 'Görüşmeler');

        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/

        //$this->crud->setFromDb();

        // ------ CRUD FIELDS
        // $this->crud->addField($options, 'update/create/both');
        // $this->crud->addFields($array_of_arrays, 'update/create/both');
        // $this->crud->removeField('name', 'update/create/both');
        // $this->crud->removeFields($array_of_names, 'update/create/both');
        //$this->crud->removeField('content', 'result');
        $this->crud->addFields([
            [
                'name' => 'course',
                'label' => 'İlgilendiği Konu',
                'type' => 'text'
            ],
            [
                'name' => 'content',
                'label' => 'Görüşme İçeriği',
                'type' => 'textarea'
            ],
            [
                'name' => 'result',
                'label' => 'Sonuç',
                'type' => 'radio',
                'options' => Interview::getResultStringArray(),
                'inline' => 'true'
            ]
        ]);
        $this->crud->addField([
            // 1-n relationship
            'label' => "Müşteri", // Table column heading
            'type' => "select2_from_ajax",
            'name' => 'customer_id', // the column that contains the ID of that connected entity;
            'entity' => 'customer', // the method that defines the relationship in your Model
            'attribute' => ["fullname", "telephone", "email", "fax"], // foreign key attribute that is shown to user
            'model' => 'App\Models\Customer', // foreign key model
            'data_source' => url("api/customer"), // url to controller search function (with /{id} should return model)
            'placeholder' => "Müşteri arayın", // placeholder for the select
            'minimum_input_length' => 2, // minimum characters to type before querying results
        ], 'create');
        $this->crud->addField([
                'name' => 'customer_id',
                'label' => "Müşteri",
                'type' => 'disabled_relation_text',
                'attribute' => 'fullname',
                'relation_model' => 'customer'
            ], 'update');


        // ------ CRUD COLUMNS
        // $this->crud->addColumn(); // add a single column, at the end of the stack
        // $this->crud->addColumns(); // add multiple columns, at the end of the stack
        // $this->crud->removeColumn('column_name'); // remove a column from the stack
        // $this->crud->removeColumns(['column_name_1', 'column_name_2']); // remove an array of columns from the stack
        // $this->crud->setColumnDetails('column_name', ['attribute' => 'value']); // adjusts the properties of the passed in column (by name)
        // $this->crud->setColumnsDetails(['column_1', 'column_2'], ['attribute' => 'value']);
        //$this->crud->removeColumns(['course','customer_id', 'content', 'result']);
        $this->crud->addColumns([
            [
                'label' => 'Müşteri',
                'type' => "model_attribute_attribute",
                'model_attribute' => 'customer',
                'model_attribute_attribute' => 'fullname'
            ],
            [
                'name' => 'course',
                'label' => 'İlgilendiği Konu',
                'type' => 'text'
            ],
            [
                'name' => 'content',
                'label' => 'İçerik',
                'type' => 'text'
            ],
            [
                'name' => 'result',
                'label' => 'Sonuç',
                'type' => 'radio',
                'options' => Interview::getResultStringArray()
            ]
        ]);

        // ------ CRUD BUTTONS
        // possible positions: 'beginning' and 'end'; defaults to 'beginning' for the 'line' stack, 'end' for the others;
        // $this->crud->addButton($stack, $name, $type, $content, $position); // add a button; possible types are: view, model_function
        // $this->crud->addButtonFromModelFunction($stack, $name, $model_function_name, $position); // add a button whose HTML is returned by a method in the CRUD model
        // $this->crud->addButtonFromView($stack, $name, $view, $position); // add a button whose HTML is in a view placed at resources\views\vendor\backpack\crud\buttons
        // $this->crud->removeButton($name);
        // $this->crud->removeButtonFromStack($name, $stack);

        // ------ CRUD ACCESS
        $this->crud->allowAccess(['list', 'create', 'update', 'reorder', 'delete', 'show']);
        // $this->crud->denyAccess(['list', 'create', 'update', 'reorder', 'delete']);

        // ------ CRUD REORDER
        // $this->crud->enableReorder('label_name', MAX_TREE_LEVEL);
        // NOTE: you also need to do allow access to the right users: $this->crud->allowAccess('reorder');

        // ------ CRUD DETAILS ROW
        // $this->crud->enableDetailsRow();
        // NOTE: you also need to do allow access to the right users: $this->crud->allowAccess('details_row');
        // NOTE: you also need to do overwrite the showDetailsRow($id) method in your EntityCrudController to show whatever you'd like in the details row OR overwrite the views/backpack/crud/details_row.blade.php

        // ------ REVISIONS
        // You also need to use \Venturecraft\Revisionable\RevisionableTrait;
        // Please check out: https://laravel-backpack.readme.io/docs/crud#revisions
        // $this->crud->allowAccess('revisions');

        // ------ AJAX TABLE VIEW
        // Please note the drawbacks of this though:
        // - 1-n and n-n columns are not searchable
        // - date and datetime columns won't be sortable anymore
        // $this->crud->enableAjaxTable();

        // ------ DATATABLE EXPORT BUTTONS
        // Show export to PDF, CSV, XLS and Print buttons on the table view.
        // Does not work well with AJAX datatables.
        // $this->crud->enableExportButtons();

        // ------ ADVANCED QUERIES
        // $this->crud->addClause('active');
        // $this->crud->addClause('type', 'car');
        // $this->crud->addClause('where', 'name', '==', 'car');
        // $this->crud->addClause('whereName', 'car');
        // $this->crud->addClause('whereHas', 'posts', function($query) {
        //     $query->activePosts();
        // });
        // $this->crud->with(); // eager load relationships
        // $this->crud->orderBy();
        // $this->crud->groupBy();
        // $this->crud->limit();
    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud();
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud();
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    /**
     * Show the form for creating inserting a new row.
     *
     * @return Response
     */
    public function create()
    {
        $this->crud->hasAccessOrFail('create');

        // prepare the fields you need to show
        $this->data['crud'] = $this->crud;
        $this->data['saveAction'] = $this->getSaveAction();
        $this->data['fields'] = $this->crud->getCreateFields();
        $this->data['title'] = trans('backpack::crud.add') . ' ' . $this->crud->entity_name;
        if ($this->crud->request->customer_id) {
            $customer = Customer::findOrFail($this->crud->request->customer_id);
            $this->data['title'] = $customer->fullname . ' adlı müşteriye görüşme ekle';
            $this->data['entry'] = $customer;
            $this->crud->removeField('customer_id');
            $this->crud->addField([
                'name' => 'customer_id',
                'label' => "Müşteri",
                'type' => 'disabled_relation_text',
                'attribute' => 'fullname',
                'model' => $customer
            ]);

            return view("crud::create_interview_for_customer", $this->data);
        }
        // load the view from /resources/views/vendor/backpack/crud/ if it exists, otherwise load the one in the package
        return view($this->crud->getCreateView(), $this->data);
    }
}
