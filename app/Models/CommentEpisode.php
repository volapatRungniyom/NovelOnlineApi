<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentEpisode extends Model
{
    use HasFactory;

    public function episode()
    {
        return $this->belongsTo(Episode::class);
    }
}
