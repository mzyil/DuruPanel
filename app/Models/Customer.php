<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Backpack\CRUD\CrudTrait;
use PhpParser\Comment\Doc;

/**
 * Class Customer
 * @package App\Models
 */
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
    public $timestamps = false;
    protected $guarded = ['customer_id'];
    // protected $fillable = [];
    //protected $hidden = ['customer_group', 'store_id', 'language_id', 'Password', 'Salt', 'Cart', 'Wishlist', 'Newsletter', 'Address_id', 'Custom_field', 'Ip', 'Status', 'Approved', 'Safe', 'Token', 'Code', 'Date_added'];
    // protected $dates = [];
    protected $appends = ["fullname"];

    /*
	|--------------------------------------------------------------------------
	| FUNCTIONS
	|--------------------------------------------------------------------------
	*/

    public function getFullnameAttribute()
    {
        return trim($this->firstname) . " " . trim($this->lastname);
    }

    /**
     * Search all fields
     * @param $search_terms string The term to search or terms seperated with a space
     * @return Builder
     */
    public static function search($search_terms)
    {
        $term = "";
        $search_function = function (Builder $query) use (&$term) {
            $query->orWhere('firstname', 'LIKE', '%' . $term . '%');
            $query->orWhere('lastname', 'LIKE', '%' . $term . '%');
            $query->orWhere('email', 'LIKE', '%' . $term . '%');
            $query->orWhere('telephone', 'LIKE', '%' . $term . '%');
            $query->orWhere('fax', 'LIKE', '%' . $term . '%');
        };
        $search_terms = explode(" ", $search_terms);
        if (count($search_terms) == 1) {
            $term = $search_terms[0];
            return Customer::where($search_function);
        } else {
            $term = $search_terms[0];
            $lastQuery = Customer::where($search_function);
            for ($i = 1; $i < count($search_terms); $i++) {
                $term = $search_terms[$i];
                $lastQuery = $lastQuery->where($search_function);
            }
            return $lastQuery;
        }
    }

    public function returnButton()
    {
        return /** @lang HTML */
            '<a href="'. url(config('backpack.base.route_prefix', 'admin') . '/customer/' . $this->getKey()) . '/edit' .'" class="btn btn-default" data-style="zoom-in"><span
                class="ladda-label"><i
                    class="fa fa-arrow-left"></i> Müşteriye Dön</span></a>';
    }

    /*
	|--------------------------------------------------------------------------
	| RELATIONS
	|--------------------------------------------------------------------------
	*/

    public function interviews()
    {
        return $this->hasMany('App\Models\Interview', "customer_id", "customer_id");
    }

    public function addresses()
    {
        return $this->hasMany('App\Models\Address', "customer_id", "customer_id");
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
