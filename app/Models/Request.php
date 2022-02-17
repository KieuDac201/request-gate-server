<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'content', 'priority', 'status', 'author_id', 'category_id',
        'person_in_charge',
    ];

    protected $primaryKey = 'id';

    protected $table = 'requests';
}
