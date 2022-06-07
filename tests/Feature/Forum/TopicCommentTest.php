<?php

declare(strict_types = 1);

namespace Tests\Feature\Forum;

use App\Models\Topic;
use App\Models\TopicComment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TopicCommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_topic_comment_with_correct_credentials()
    {
        $user = User::factory()
            ->has(Topic::factory())
            ->create();

        $topic = $user->topics[0];

        $topicComment = TopicComment::factory()
            ->make([
                'user_id' => $user->id,
                'topic_id' => $topic->id,
            ]);

        $response = $this->actingAs($user)
            ->post(route('topic-comment.store', [
                'topic_id' => $topic->id,
                'text' => $topicComment->text
            ]));

        $response->assertRedirect(route('topic.get', ['id' => $topic->id]))
            ->assertSessionHasNoErrors()
            ->assertSessionHas('comment-create-success');
    }
}
