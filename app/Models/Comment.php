<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'request_id', 'user_id', 'content'
    ];

    protected $primaryKey = 'id';

    protected $table = 'comments';
}
