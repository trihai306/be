<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'user_id',
        'post_id',
        'star',
        'content',
        'image',
        'status',
    ];

    /**
     * Get the user associated with the review.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the post associated with the review.
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
