<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'history_id', 'change_field', 'old_value', 'new_value'
    ];

    protected $primaryKey = 'id';

    protected $table = 'history_details';
}
