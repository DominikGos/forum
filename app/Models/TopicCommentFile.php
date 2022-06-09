<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopicCommentFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'topic_comment_id',
        'text',
        'path'
    ];

}
