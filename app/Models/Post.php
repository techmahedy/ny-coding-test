<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    
    protected $fillable = [
        'title',
        'user_id'
    ];
    
    /**
     * A Post must belong to a User
     */
    public function user() : BelongsTo
    {
       return $this->belongsTo(User::class);
    }

    public function scopeTopUser(Builder $query)
    {   
        return $query->whereBetween('created_at', [
            Carbon::now()->subDays(7)->format('Y-m-d H:i:m'),
            Carbon::now()->format('Y-m-d H:i:m'),
        ]);
    }
}
