<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Novel extends Model
{
    use HasFactory,SoftDeletes;

    public function episodes()
    {
        return $this->hasMany(Episode::class);
    }

    public function comments()
    {
        return $this->hasMany(CommentNovel::class);
    }

    public function tags(){
        return $this->belongsToMany(Tag::class);
    }

    public function users(){
        return $this->belongsToMany(User::class)->withPivot('is_owner');
    }

}
