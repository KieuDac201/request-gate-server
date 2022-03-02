<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;
    protected $fillable = [
        'request_id', 'user_id', 'content', 'type'
    ];

    protected $primaryKey = 'id';

    protected $table = 'histories';
}
