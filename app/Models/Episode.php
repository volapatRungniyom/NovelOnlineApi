<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Episode extends Model
{
    use HasFactory,SoftDeletes;

    public function novel()
    {
        return $this->belongsTo(Novel::class);
    }

    public function comments()
    {
        return $this->hasMany(CommentEpisode::class);
    }

}
