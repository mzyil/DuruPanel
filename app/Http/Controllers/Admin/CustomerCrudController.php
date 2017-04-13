<?php

namespace App\Http\Controllers\Admin;

use App\Models\Address;
use App\Models\Customer;
use App\Models\Interview;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\CustomerRequest as StoreRequest;
use App\Http\Requests\CustomerRequest as UpdateRequest;
use Barryvdh\Debugbar\Middleware\Debugbar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use LiveControl\EloquentDataTable\DataTable;

/**
 * Class CustomerCrudController
 * @package App\Http\Controllers\Admin
 */
class CustomerCrudController extends CrudController
{

    public function setUp()
    {
        $attrNames = [
            [
                'name' => 'firstname',
                'label' => 'İsim',
                'type' => 'text'
            ],
            [
                'name' => 'lastname',
                'label' => 'Soyisim',
                'type' => 'text'
            ],
            [
                'name' => 'telephone',
                'label' => 'Telefon',
                'type' => 'text'
            ],
            [
                'name' => 'email',
                'label' => 'Email',
                'type' => 'email'
            ],
            [
                'name' => 'fax',
                'label' => 'TC',
                'type' => 'number'
            ],
        ];

        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
        $this->crud->setModel("App\Models\Customer");
        $this->crud->setRoute("admin/customer");
        $this->crud->setEntityNameStrings('Müşteri', 'Müşteriler');

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
        //$this->crud->removeFields(
        //    ['customer_id', 'customer_group_id', 'store_id', 'language_id', 'password', 'salt', 'cart', 'wishlist', 'newsletter', 'address_id', 'custom_field', 'ip', 'status', 'approved', 'safe', 'token', 'code', 'date_added'],
        //    'update/create/both');
        $this->crud->addFields($attrNames);
        $this->crud->addField([
            'label' => "Adres(ler)",
            'type' => 'custom_address',
            'name' => 'address_1', // the db column for the foreign key
            'entity' => 'addresses', // the method that defines the relationship in your Model
            'attribute' => ['address_1', 'address_2', 'city', 'postcode'], // foreign key attribute that is shown to user
            'labels' => [
                'address_1' => 'Adres Satırı 1',
                'address_2' => 'Adres Satırı 2',
                'city' => 'Şehir',
                'postcode' => 'Posta Kodu',
            ],
            'model' => 'App\Models\Address', // foreign key model
            'select2_country_name' => 'address[__ID__][country_id]',
            'select2_zone_name' => 'address[__ID__][zone_id]',
            'select2_country' => [
                'label' => "Ülke", // Table column heading
                'type' => "select2_from_ajax",
                'entity' => 'country', // the method that defines the relationship in your Model
                'attribute' => "name", // foreign key attribute that is shown to user
                'model' => 'App\Models\Country', // foreign key model
                'data_source' => url("api/countries"), // url to controller search function (with /{id} should return model)
                'placeholder' => "Ülke seçin", // placeholder for the select
                'minimum_input_length' => 2, // minimum characters to type before querying results
                "idname" => "country_id__ID__",
                "model_attr" => "country_id",
            ],
            'select2_zone' => [
                'label' => "Bölge Seçin", // Table column heading
                'type' => "select2_from_ajax",
                'entity' => 'zone', // the method that defines the relationship in your Model
                'attribute' => "name", // foreign key attribute that is shown to user
                'model' => 'App\Models\Zone', // foreign key model
                'data_source' => url("api/zones") . "/{country_id}", // url to controller search function (with /{id} should return model)
                'placeholder' => "Bölge seçin", // placeholder for the select
                'minimum_input_length' => 0, // minimum characters to type before querying results
                "idname" => "zone_id__ID__",
                "replacepart" => "{country_id}",
                "data_source_single" => url("api/zones/show"),
                "model_attr" => "zone_id",
            ]
        ], 'update');
        $this->crud->addField([
            'type' => 'custom_address_create',
            'name' => 'custom_address_create', // the db column for the foreign key
            'attribute' => ['address_1', 'address_2', 'city', 'postcode'], // foreign key attribute that is shown to user
            'labels' => [
                'address_1' => 'Adres Satırı 1',
                'address_2' => 'Adres Satırı 2',
                'city' => 'Şehir',
                'postcode' => 'Posta Kodu',
            ],
            'select2_country' => [
                'label' => "Ülke", // Table column heading
                'type' => "select2_from_ajax",
                'name' => 'address[__ID__][country_id]', // the column that contains the ID of that connected entity;
                'entity' => 'country', // the method that defines the relationship in your Model
                'attribute' => "name", // foreign key attribute that is shown to user
                'model' => 'App\Models\Country', // foreign key model
                'data_source' => url("api/countries"), // url to controller search function (with /{id} should return model)
                'placeholder' => "Ülke seçin", // placeholder for the select
                'minimum_input_length' => 2, // minimum characters to type before querying results
                "idname" => "country_id__ID__",
                "classsuffix" => "country"
            ],
            'select2_zone' => [
                'label' => "Bölge Seçin", // Table column heading
                'type' => "select2_from_ajax",
                'name' => 'address[__ID__][zone_id]', // the column that contains the ID of that connected entity;
                'entity' => 'zone', // the method that defines the relationship in your Model
                'attribute' => "name", // foreign key attribute that is shown to user
                'model' => 'App\Models\Zone', // foreign key model
                'data_source' => url("api/zones") . "/{country_id}", // url to controller search function (with /{id} should return model)
                'placeholder' => "Bölge seçin", // placeholder for the select
                'minimum_input_length' => 0, // minimum characters to type before querying results
                "idname" => "zone_id__ID__",
                "classsuffix" => "zone",
                "replacepart" => "{country_id}",
                "data_source_single" => url("api/zones/show"),
            ]
        ], 'create');


        // ------ CRUD COLUMNS
        // $this->crud->addColumn(); // add a single column, at the end of the stack
        // $this->crud->addColumns(); // add multiple columns, at the end of the stack
        // $this->crud->removeColumn('column_name'); // remove a column from the stack
        //$this->crud->removeColumns(['customer_id', 'customer_group_id', 'store_id', 'language_id', 'password', 'salt', 'cart', 'wishlist', 'newsletter', 'address_id', 'custom_field', 'ip', 'status', 'approved', 'safe', 'token', 'code', 'date_added']); // remove an array of columns from the stack
        $this->crud->setColumns($attrNames);
        // $this->crud->setColumnDetails('column_name', ['attribute' => 'value']); // adjusts the properties of the passed in column (by name)
        // $this->crud->setColumnsDetails(['column_1', 'column_2'], ['attribute' => 'value']);

        // ------ CRUD BUTTONS
        // possible positions: 'beginning' and 'end'; defaults to 'beginning' for the 'line' stack, 'end' for the others;
        // $this->crud->addButton($stack, $name, $type, $content, $position); // add a button; possible types are: view, model_function
        // $this->crud->addButtonFromModelFunction($stack, $name, $model_function_name, $position); // add a button whose HTML is returned by a method in the CRUD model
        //$this->crud->removeAllButtonsFromStack("line");
        $this->crud->addButtonFromView("line", "interviews", "interviewbutton", "beginning"); // add a button whose HTML is in a view placed at resources\views\vendor\backpack\crud\buttons
        // $this->crud->removeButton("update");
        //if(strpos("create",$this->crud->getRoute()) !== false){
        //  $this->crud->addButtonFromView("bottom", "add_address_field", "add_address_field", "end");


        // ------ CRUD ACCESS
        $this->crud->allowAccess(['list', 'create', 'update', 'reorder', 'show']);
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
        $this->crud->with('address'); // eager load relationships
        // $this->crud->orderBy();
        // $this->crud->groupBy();
        //$this->crud->limit(25);
    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $addresses = $request->only('address');
        $request->offsetUnset('address');
        $request->offsetSet('customer_group_id', '13');
        $request->offsetSet('language_id', '0');
        $request->offsetSet('password', 'be65b4f23ff73c9b7a1af7311ef0a56b2cd87411');
        $request->offsetSet('salt', 'gbCZ1CpLR');
        $request->offsetSet('newsletter', '0');
        $request->offsetSet('custom_field', ' ');
        $request->offsetSet('ip', $request->ip());
        $request->offsetSet('status', '0');
        $request->offsetSet('approved', '1');
        $request->offsetSet('safe', '0');
        $request->offsetSet('token', ' ');
        $request->offsetSet('code', ' ');
        $request->offsetSet('date_added', date("Y-m-d H:i:s"));

        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        /**
         * @type $entry \App\Models\Customer
         */
        $entry = $this->crud->entry;
        if(empty($addresses)){
            return $redirect_location;
        }
        foreach ($addresses['address'] as $address) {
            $temp = new Address(
                [
                    "customer_id" => $entry->customer_id,
                    "firstname" => $entry->firstname,
                    "lastname" => $entry->lastname,
                    "company" => ' ',
                    "address_1" => $address["address_1"],
                    "address_2" => $address["address_2"],
                    "city" => $address["city"],
                    "postcode" => $address["postcode"],
                    "country_id" => $address["country_id"],
                    "zone_id" => $address["zone_id"],
                    "custom_field" => ' ',
                ]);
            $temp->save();
        }
        $entry->address_id = $entry->addresses[0]->address_id;
        $entry->save;
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $addresses = $request->only('address');
        $request->offsetUnset('address');
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        /**
         * @type $entry \App\Models\Customer
         */
        $entry = $this->crud->entry;
        foreach ($addresses['address'] as $address) {
            $temp = $entry->addresses()->where('address_id', '=', (empty($address["address_1"]) && $address["address_1"] !== '0') ? "-1" : $address['address_id'])->first();
            if (!$temp) {
                $temp = new Address();
            }
            $newData = [
                "customer_id" => $entry->customer_id,
                "firstname" => $entry->firstname,
                "lastname" => $entry->lastname,
                "company" => ' ',
                "custom_field" => ' ',
            ];
            if (!(empty($address["address_1"]) && $address["address_1"] !== '0' && $address["address_1"] == null)) {
                $newData["address_1"] = $address["address_1"];
            }
            if (!(empty($address["address_2"]) && $address["address_2"] !== '0' && $address["address_2"] == null)) {
                $newData["address_2"] = $address["address_2"];
            }
            if (!(empty($address["city"]) && $address["city"] !== '0' && $address["city"] == null)) {
                $newData["city"] = $address["city"];
            }
            if (!(empty($address["postcode"]) && $address["postcode"] !== '0' && $address["postcode"] == null)) {
                $newData["postcode"] = $address["postcode"];
            }
            if (!(empty($address["country_id"]) && $address["country_id"] !== '0' && $address["country_id"] == null)) {
                $newData["country_id"] = $address["country_id"];
            }
            if (!(empty($address["zone_id"]) && $address["zone_id"] !== '0' && $address["zone_id"] == null)) {
                $newData["zone_id"] = $address["zone_id"];
            }
            $temp->fill($newData);
            $temp->save();
        }
        return $redirect_location;
    }

    public function apiIndex(Request $request)
    {
        $search_term = $request->input('q');
        $page = $request->input('page');
        if ($search_term) {
            return Customer::search($search_term)->paginate(10);
        }
        return Customer::paginate(10);
    }

    public function apiShow($id)
    {
        return Customer::findOrFail($id);
    }

    public function interviews($customer_id)
    {
        $customer = Customer::findOrFail($customer_id);
        $this->data['crud'] = $this->crud;
        $this->data['title'] = ucfirst($customer->fullname) . " ile yapılan görüşmeler";
        $this->data['customer_name'] = ucfirst($customer->fullname);

        // get all entries if AJAX is not enabled
        $this->data['entries'] = $customer->interviews;
        $this->data['entry'] = $customer;

        $this->crud->removeAllButtons();
        $this->crud->addButton('line', 'update', 'view', 'crud::buttons.interview_update', 'end');
        $this->crud->addButton('line', 'delete', 'view', 'crud::buttons.interview_delete', 'end');
        $this->crud->addButton('top', 'create', 'view', 'crud::buttons.interview_create', 'end');
        $this->crud->addButtonFromModelFunction('top', 'turn_back', 'returnButton', 'end');

        $this->crud->columns = [
            [
                'label' => 'İlgilendiği Konu',
                'name' => 'course',
            ],
            [
                'label' => 'İçerik',
                'name' => 'content',
            ],
            [
                'name' => 'result',
                'label' => 'Sonuç',
                'type' => 'radio',
                'options' => Interview::getResultStringArray()
            ]
        ];

        // load the view from /resources/views/vendor/backpack/crud/ if it exists, otherwise load the one in the package
        return view("crud::show_interview", $this->data);
    }

    public function search()
    {
        $this->crud->hasAccessOrFail('list');
        // create an array with the names of the searchable columns
        $columns = collect($this->crud->columns)
            ->reject(function ($column, $key) {
                // the select_multiple, model_function and model_function_attribute columns are not searchable
                return isset($column['type']) && ($column['type'] == 'select_multiple' || $column['type'] == 'model_function' || $column['type'] == 'model_function_attribute');
            })
            ->pluck('name')
            // add the primary key, otherwise the buttons won't work
            ->merge($this->crud->model->getKeyName())
            ->toArray();

        // structure the response in a DataTable-friendly way
        $dataTable = new DataTable(Customer::search($this->crud->request->input('search')['value']), $columns);

        // make the datatable use the column types instead of just echoing the text
        $dataTable->setFormatRowFunction(function ($entry) {
            // get the actual HTML for each row's cell
            $row_items = $this->crud->getRowViews($entry, $this->crud);

            // add the buttons as the last column
            if ($this->crud->buttons->where('stack', 'line')->count()) {
                $row_items[] = \View::make('crud::inc.button_stack', ['stack' => 'line'])
                    ->with('crud', $this->crud)
                    ->with('entry', $entry)
                    ->render();
            }

            // add the details_row buttons as the first column
            if ($this->crud->details_row) {
                array_unshift($row_items, \View::make('crud::columns.details_row_button')
                    ->with('crud', $this->crud)
                    ->with('entry', $entry)
                    ->render());
            }

            return $row_items;
        });

        return json_encode($dataTable->make());
    }


}
