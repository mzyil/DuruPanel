<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasSelect2Array;
    /*
	|--------------------------------------------------------------------------
	| GLOBAL VARIABLES
	|--------------------------------------------------------------------------
	*/
    protected $connection = "mysql2";
    protected $table = 'oc_country';
    protected $primaryKey = 'country_id';
    public $timestamps = false;
    //protected $guarded = ['country_id'];
    protected $fillable = ['status'];

    // protected $hidden = [];
    // protected $dates = [];

    public function addresses()
    {
        return $this->hasMany('App\Models\Address', "country_id", "country_id");
    }
    public function zones()
    {
        return $this->hasMany('App\Models\Zone', "country_id", "country_id");
    }
}
