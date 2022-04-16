<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;


class Channel extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'image',
    ];

    /**
     * we have made a Event Listener for CreateUserChannel
     * then Register it in Event Service providers of Registerd::class
     * when ever a new user is created it will automatically 
     * create channel for it 
     * event and listers are used for this perpose.when ever an event is trigried
     * the coresponding listner is run/triggered..
     * the remaining explaination is in Listerers/User/CreateChannelUser.php  Listerner
     * 
     */

     public function user()
     {
         return $this->belongsTo(User::class);
     }


     /**
      * this function is going to convert the image along with its thumbnail automatically
      * it will create a new folder in resources with Conversion name 
      */
     public function registerMediaCollections(?Media $media=null): void
     {
         $this->addMediaConversion('thumb')->width(100)->height(100);
     }

     /**
      * function to retrive the media from database
      * here media is a relationship with media table
      * due to ...use InteractsWithMedia; (if we click on InteractsWithMedia class it will shoe nedia function returning a relationship with media table)
      * and     class Channel extends Model implements HasMedia(this has media trait)
      * then we will use getFullUrl() to get the specific converion
      * by providing name as a string in the function getFullUrl('thumb')
      * we giv name thumb to media connverion in the above function 
      *
      */

     public function image(){
         if ($this->media->first())
          {
             return  $this->media->first()->getFullUrl('thumb');
            //  dd($this->media->first()->getFullUrl('thumb'));
          }

          return null;
     } 

     /**
      * we define function here to check the user id with the channel id
      * only authorise user can access or see the update button and its interface
      * other users will see it in a different way
      * these function will be used in a show.balde template
      */

      public function editable()
      {
          /**
           * if user is not authanticated means login 
           */
          if (! auth()->check()) {
              return false;
          }

          /**
           * if user is authanticated than return this below line 
           */
          return $this->user_id == Auth()->user()->id;
      }

      /**
       * has many relationships with Subscriptions
       */

      public function subscriptions(){
          return $this->hasMany(Subscription::class);
      }


      /**
       * has Many relation with Videos bc A channel can have many videos
       */

       public function videos(){
           return $this->hasMany(Video::class);
       }

}
