<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Votes extends Model
{
    use HasFactory;
    protected $fillable = [
        'type',
        'user_id',
        'voteable_type',
     ];
    public function voteable(){
        return $this->morphTo();

    }
}
