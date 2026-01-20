<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discussion extends Model
{
    // Add user_id to fillable
    protected $fillable = ['title', 'content', 'user_id'];

    // Relationship: Discussion belongs to a User (author)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship: Discussion has many comments
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
