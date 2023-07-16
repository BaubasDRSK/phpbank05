<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    public function client()
    {
        return $this->belongsTo(Client::class);
        // return $this->belongsTo(Author::class, 'author_id', 'id');
    }
}
