<?php

declare(strict_types = 1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'text'
    ];

    public function topicComments() {
        return $this->hasMany(TopicComment::class);
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function topicFiles() {
        return $this->hasMany(TopicFile::class);
    }
}
