<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;


class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'body',
        'video_id',
        'comment_id',
    ];

    /**
     * this tell laravel to automatically Eadger load when fetching the comments of User who Created the Comments  
     */
    protected $with = ['user','votes'];
    protected $appends = ['repliesCount']; //if you want computed property into json response add it to apends array



    public function user(){
        return $this->belongsTo(User::class);
    }

    public function video(){
        return $this->belongsTo(Video::class);
    }

    public function replies(){
        return $this->hasMany(Comment::class, 'comment_id' /** foreign key to tell that deal comment_id as forign key */)->whereNotNull('comment_id');//whereNotNull is used for where specific colomn is not null
    }

    /**
     * getting Replies count as a laravel computed property and this will not be available in json reponse for that we will append the
     *  colomn name getting form count function which will be replies_count in an $append 
     */
    public function getRepliesCountAttribute(){
        return $this->replies->count();
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

}
