<?php
/**
 * Created by PhpStorm.
 * User: Melih
 * Date: 6.04.2017
 * Time: 16:58
 */

namespace app\Models;

use Illuminate\Support\Facades\DB;

trait HasSelect2Array
{
    public static function getSelect2Array($records, $valueField)
    {
        /**
         * @var $records \Illuminate\Database\Eloquent\Collection
         */
        $output = [];
        foreach ($records as $record){
            $output[] = [$record->getKey() => $record->$valueField];
        }
        return $output;
    }
}