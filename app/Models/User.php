<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username'
    ];

    /**
     * A User can have many Posts
     */
    public function posts() : HasMany
    {
        return $this->hasMany(Post::class)->topUser();
    }
   
    public function lastPost ()
    {
        return $this->hasOne(Post::class)->orderBy('created_at', 'desc');
    }

    public function getUserPostCountAttribute()
    {
        return $this->posts()->count();
    }

    public function lastSevenDaysUserWhoDidPost()
    {
        return $this->whereHas('posts', function (Builder $query){
            $query->topUser();
        });
    }

    public function userListCollection($query)
    {
        return $query->map(function($data)
        {
            return [
                'username' => $data->username,
                'total_posts_count' => $data->user_post_count,
                'last_post_title' => $data->lastPost->title
            ];
        });
    }

    public function userWhoDidTenPost($query)
    {
        return $query->filter(function($query){
                    return $query->user_post_count > 1;
                });
    }

    public function users()
    {
        $users = $this->lastSevenDaysUserWhoDidPost()->get();
        $users = $this->userWhoDidTenPost($users);
        $users = $this->userListCollection($users);

        return $users;
    }

}
