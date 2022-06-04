<?php

declare(strict_types = 1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    public function comments() {
        return $this->hasMany(TopicComment::class);
    }

    public function author() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
