<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\UserStatusEnum;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'status'
    ];
    protected $primaryKey = 'id';

    protected $table = 'categories';

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_categories', 'cate_id')
            ->where('status', '=', UserStatusEnum::USER_ACTIVE_STATUS);
    }
}
