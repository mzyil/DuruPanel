<?php

namespace App\Http\Controllers\Admin;

use App\Models\Customer;
use App\Models\Interview;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\CustomerRequest as StoreRequest;
use App\Http\Requests\CustomerRequest as UpdateRequest;
use Illuminate\Http\Request;

class CustomerCrudController extends CrudController
{

    public function setUp()
    {

        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
        $this->crud->setModel("App\Models\Customer");
        $this->crud->setRoute("admin/customer");
        $this->crud->setEntityNameStrings('customer', 'customers');

        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/

        $this->crud->setFromDb();

        // ------ CRUD FIELDS
        // $this->crud->addField($options, 'update/create/both');
        // $this->crud->addFields($array_of_arrays, 'update/create/both');
        // $this->crud->removeField('name', 'update/create/both');
        // $this->crud->removeFields($array_of_names, 'update/create/both');


        // ------ CRUD COLUMNS
        // $this->crud->addColumn(); // add a single column, at the end of the stack
        // $this->crud->addColumns(); // add multiple columns, at the end of the stack
        // $this->crud->removeColumn('column_name'); // remove a column from the stack
        //$this->crud->removeColumns(['customer_id', 'customer_group_id', 'store_id', 'language_id', 'password', 'salt', 'cart', 'wishlist', 'newsletter', 'address_id', 'custom_field', 'ip', 'status', 'approved', 'safe', 'token', 'code', 'date_added']); // remove an array of columns from the stack
        $this->crud->setColumns(["firstname", "lastname", "telephone", "email", "fax"]);
        // $this->crud->setColumnDetails('column_name', ['attribute' => 'value']); // adjusts the properties of the passed in column (by name)
        // $this->crud->setColumnsDetails(['column_1', 'column_2'], ['attribute' => 'value']);

        // ------ CRUD BUTTONS
        // possible positions: 'beginning' and 'end'; defaults to 'beginning' for the 'line' stack, 'end' for the others;
        // $this->crud->addButton($stack, $name, $type, $content, $position); // add a button; possible types are: view, model_function
        // $this->crud->addButtonFromModelFunction($stack, $name, $model_function_name, $position); // add a button whose HTML is returned by a method in the CRUD model
        // $this->crud->addButtonFromView($stack, $name, $view, $position); // add a button whose HTML is in a view placed at resources\views\vendor\backpack\crud\buttons
        $this->crud->removeButton("edit");
        // $this->crud->removeButtonFromStack($name, $stack);

        // ------ CRUD ACCESS
        // $this->crud->allowAccess(['list', 'create', 'update', 'reorder', 'delete']);
        // $this->crud->denyAccess(['list', 'create', 'update', 'reorder', 'delete']);

        // ------ CRUD REORDER
        //$this->crud->enableReorder('firstname', 1);
        //$this->crud->allowAccess('reorder');
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
        $this->crud->enableAjaxTable();

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
        //$this->crud->limit(25);
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

    public function apiIndex(Request $request)
    {
        $search_term = $request->input('q');
        $page = $request->input('page');
        if ($search_term) {
            $search_terms = explode(" ", $search_term);
            if(count($search_terms) == 1) {
                $results = Customer::where('firstname', 'LIKE', '%' . $search_term . '%')
                    ->orWhere('lastname', 'LIKE', '%' . $search_term . '%')
                    ->orWhere('email', 'LIKE', '%' . $search_term . '%')
                    ->orWhere('telephone', 'LIKE', '%' . $search_term . '%')
                    ->orWhere('fax', 'LIKE', '%' . $search_term . '%')
                    ->paginate(10);
            }else{
                $zeroElem = $search_terms[0];
                $lastQuery = Customer::where(function($query) use ($zeroElem){
                    $query->orWhere('firstname', 'LIKE', '%' . $zeroElem . '%');
                    $query->orWhere('lastname', 'LIKE', '%' . $zeroElem . '%');
                    $query->orWhere('email', 'LIKE', '%' . $zeroElem . '%');
                    $query->orWhere('telephone', 'LIKE', '%' . $zeroElem . '%');
                    $query->orWhere('fax', 'LIKE', '%' . $zeroElem . '%');
                });
                for($i=1;$i<count($search_terms);$i++) {
                    $currElem = $search_terms[$i];
                    $lastQuery = $lastQuery->where(function ($query) use ($currElem) {
                        $query->orWhere('firstname', 'LIKE', '%' . $currElem . '%');
                        $query->orWhere('lastname', 'LIKE', '%' . $currElem . '%');
                        $query->orWhere('email', 'LIKE', '%' . $currElem . '%');
                        $query->orWhere('telephone', 'LIKE', '%' . $currElem . '%');
                        $query->orWhere('fax', 'LIKE', '%' . $currElem . '%');
                    });
                }
                return $lastQuery->paginate(10);
            }
        } else {
            $results = Customer::paginate(10);
        }

        return $results;
    }

    public function apiShow($id)
    {
        return Customer::find($id);
        //echo json_encode(Interview::find($id)->customer);
        //return view("vendor.backpack.base.dashboard");
    }
}
