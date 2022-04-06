<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Video extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'path',
        'percentage',
        'thumbnail',
        'video',
    ];

    

    /***
     * define that this video belongs to Owner Channel
     */
    public function channel(){
        return $this->belongsTo(Channel::class);
    }

    /***
     * it will check that logged-in user is Owner of the Channel and video or not
     * if it is Owner then he can Edit the video Information
     */
    public function editable(){
        return auth()->check() && $this->channel->user_id === auth()->user()->id;
    }

/**
 * Polymorphic Morph relationship with Votes it with Automaticaly 
 * when this function is called  it will set Variable type to App\Models\Video
 * it will automaticaly get the Model name and store it in a Table
 *  
 * */     
    public function votes(){
        return $this->morphMany(Votes::class,'voteable');
        
    }

    public function comments(){
        return $this->hasMany(Comment::class)->whereNull('comment_id')->orderBy('created_at', 'DESC');//whereNull is used for .. where the specific colomn is null
    }
}
 