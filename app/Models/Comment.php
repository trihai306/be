<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'post_id',
        'user_id',
        'note',
        'date_start',
        'date_end',
        'money',
    ];

    /**
     * Get the post associated with the comment.
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Get the user associated with the comment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
