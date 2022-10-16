<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentNovel extends Model
{
    use HasFactory;

    public function novel()
    {
        return $this->belongsTo(Novel::class);
    }

}
