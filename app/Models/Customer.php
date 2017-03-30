<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Customer extends Model
{
    use CrudTrait;

     /*
	|--------------------------------------------------------------------------
	| GLOBAL VARIABLES
	|--------------------------------------------------------------------------
	*/
    protected $connection = "mysql2";
    protected $table = 'oc_customer';
    protected $primaryKey = 'customer_id';
    // public $timestamps = false;
    protected $guarded = ['customer_id'];
    // protected $fillable = [];
    //protected $hidden = ['customer_group', 'store_id', 'language_id', 'Password', 'Salt', 'Cart', 'Wishlist', 'Newsletter', 'Address_id', 'Custom_field', 'Ip', 'Status', 'Approved', 'Safe', 'Token', 'Code', 'Date_added'];
    // protected $dates = [];

    /*
	|--------------------------------------------------------------------------
	| FUNCTIONS
	|--------------------------------------------------------------------------
	*/

    /*
	|--------------------------------------------------------------------------
	| RELATIONS
	|--------------------------------------------------------------------------
	*/

    public function interviews()
    {
        return $this->hasMany('App\Models\Interview', "customer_id", "customer_id");
    }

    /*
	|--------------------------------------------------------------------------
	| SCOPES
	|--------------------------------------------------------------------------
	*/

    /*
	|--------------------------------------------------------------------------
	| ACCESORS
	|--------------------------------------------------------------------------
	*/

    /*
	|--------------------------------------------------------------------------
	| MUTATORS
	|--------------------------------------------------------------------------
	*/
}
