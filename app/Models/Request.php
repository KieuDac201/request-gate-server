<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Request extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'content', 'priority', 'status', 'author_id', 'category_id',
        'person_in_charge','due_date'
    ];

    protected $primaryKey = 'id';

    protected $table = 'requests';

    protected static function boot()
    {
        parent::boot();

        $userId =Auth::user()->id;
        static::creating(function ($model) use ($userId) {
            if (!$model->isDirty('author_id')) {
                $model->author_id = $userId;
            }
        });
    }

    public function createby()
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }
}
