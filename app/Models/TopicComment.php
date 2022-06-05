<?php

declare(strict_types = 1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopicComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'topic_id',
        'text',
    ];

    public function author() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function topic() {
        return $this->belongsTo(Topic::class);
    }
}
