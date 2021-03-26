<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Comment extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['post_id', 'name','email','body'];

    public function toSearchableArray()
    {
        $array = $this->toArray();

        // Customize the data array...

        return $array;
    }


    public function post()
    {
        return $this->belongsTo(\App\Models\Post::class);
    }
}
