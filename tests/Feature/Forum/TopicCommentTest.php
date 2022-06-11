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
        $user = User::factory()->create();

        $topic = Topic::factory()
            ->for($user)
            ->create();

        $topicComment = TopicComment::factory()
            ->make([
                'user_id' => $user->id,
                'topic_id' => $topic->id,
            ]);

        $response = $this->actingAs($user)
            ->post(route('topic.comment.store', [
                'topic_id' => $topic->id,
                'text' => $topicComment->text
            ]));

        $response->assertRedirect(route('topic.get', ['id' => $topic->id]))
            ->assertSessionHasNoErrors()
            ->assertSessionHas('comment-create-success');
    }

    public function test_user_can_delete_own_comment(): void
    {
        $user = User::factory()->create();

        $topic = Topic::factory()
            ->for($user)
            ->create();

        $topicComment = TopicComment::factory()
            ->create([
                'user_id' => $user->id,
                'topic_id' => $topic->id,
            ]);

        $response = $this->actingAs($user)
            ->delete(route('topic.comment.destroy', [
                'id' => $topicComment->id,
            ]));

        $response->assertRedirect(route('topic.get', ['id' => $topic->id]))
            ->assertSessionHas(['topic-comment-delete-success']);
    }

    public function test_user_cannot_delete_not_his_comment(): void
    {
        $firstUser = User::factory()->create();

        $secondUser = User::factory()->create();

        $secondUserTopic = Topic::factory()
            ->for($secondUser)
            ->create();

        $secondUserTopicComment = TopicComment::factory()
            ->create([
                'user_id' => $secondUser->id,
                'topic_id' => $secondUserTopic->id,
            ]);

        $response = $this->actingAs($firstUser)
            ->delete(route('topic.comment.destroy', [
                'topic_comment_id' => $secondUserTopicComment->id,
            ]));

        $response->assertRedirect(route('topic.get', ['id' => $secondUserTopic->id]))
            ->assertSessionHasErrors(['topic-comment-delete-faile']);
    }
}
