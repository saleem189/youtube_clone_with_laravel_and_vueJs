<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Support\Str;


class Model extends BaseModel
{
    use HasFactory;
    /**
     * All the Models are gong to Extend This Model Beacuse we have made a custom Model 
     * which is Extended from Laravel BaseModel
     * and here we define A UUID insted of ID.
     * Beacuse we Want UUID as our defaut ID for all tables/Models 
     * below functions are going to make a unique uuid for every model/table/user/row
     * Now any model i want to have this functionality is simply going to
     * extend it 
     */

    /**
     * Here will False the $incrementing property because it is used by id  which
     * are Auto Incremental .. To use UUID as Primary key for table we will Fasle the 
     * incrementing prperty for that table.. and Thses proberties are by default present in Main Model
     * the Abbstract Model class through which all models are Extended
     * as we make it to False .. so we will set the id(which in UUID) before the User is created to the Model
     * by Model Events which are Creating,created,inserting,inserted,deleting,deleted,updating,updated which i coverd in Realtions.. Project Name: realtions
     * as we see ..the autoincrementing property is False ..So we gona make a Unique User ID before it is stored and assign it to user 
     */

    public $incrementing = false;

    /**
     * this method is in Model.php of Laravel ..An abstract Model through all Models are Extended
     * 
     */
    protected static function boot()
    {
        parent::boot();

        /**
         * Register Model Boot for Method. Which is Model Event 
         * this function means that whenever  data is Actually created into DataBase. it is 
         * going to call our function. this function is to set the Id to String::UUID
         * we use $model->getKeyName() function .. which will return the Primary key of table
         */

         static::creating(function ($model){
             $model->{ $model->getKeyName() } = (string) Str::uuid();

         });
    }

}
