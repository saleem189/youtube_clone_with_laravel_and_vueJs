<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'country_id',
        'state_id',
        'city_id',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $appends = ['role'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

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
    public function channel()
    {
        return $this->hasOne(Channel::class);
    }
    
    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function toggleVote($entity, $type){
        /**
         * dealing entity as object as we see we are passing video object in Video Controller
         * and that video object is getting as Entity here and $this->id is the current model id
         * $video->votes->where('user_id','current_user_id')
         */
        $vote = $entity->votes->where('user_id', $this->id)->first();

        /**
         * checking if it has voted than update it in database
         */
        if($vote){
            $vote->update([
                'type' => $type
            ]);

            return $vote->refresh();
        }
        /**
         * if it has never voted then creating vote for it
         */
        else{
            return $entity->votes()->create([
                'type' => $type,
                'user_id' => $this->id
            ]);
        }

       
    }


    public function city(){
        $this->hasOne(Cities::class);
    }
    public function country(){
        $this->hasOne(Country::class);
    }
    public function state(){
        $this->hasOne(State::class);
    }
   

    /**
     * A mutator transforms an Eloquent attribute value when it is set. To define a 
     * mutator, define a set{Attribute}Attribute method on your model where 
     * {Attribute} is the "studly" cased name of the column you wish to access.
     * in short mutators are used to perform action on value before saving into database
     */
    public function setNameAttribute($value){
        $this->attributes['name'] = ucwords($value);
    }

    /**
     * An accessor transforms an Eloquent attribute value when it is accessed.
     * To define an accessor, create a get{Attribute}Attribute method on your model where {Attribute} is the "studly" cased name of the column you wish to access.
     * In this example, we'll define an accessor for the name attribute.
     * The accessor will automatically be called by Eloquent when attempting to retrieve the value of the name attribute:
     * 
     */
   
    public function getNameAttribute($value){
        return ucfirst($value);
    }

    public function getIsAdminAttribute(){
        return $this->role_id == 2;
    }
    public function getIsChannelOwnerAttribute(){
        return $this->role_id == 3;
    }
    public function getIsUserAttribute(){
        return $this->role_id == 1;
    }
    public function getRoleAttribute(){
        /**
         * if no role is attach to user then default role is attach to it and then show its name
         */
        if($this->role_id == null){
            $this->role_id = 1;
            $this->save();
            $role = Role::where('id',$this->role_id)->first();
            return $role->name;
        }
        /**
         * if role is attach to user then show its name
         */
        else{
            $role = Role::where('id',$this->role_id)->first();
            return $role->name;
        }
        
        
    }

    public function getRoleCountAttribute(){
        return $this->role->count();
    }

 


}
