<?php

declare(strict_types = 1);

namespace Tests\Feature\Forum;

use App\Models\Topic as ModelTopic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TopicTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_get_all_topics(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('topic.list'));

        $response->assertStatus(200)
            ->assertViewIs('topic-list')
            ->assertViewHas(['topics', 'numberOfTopics']);
    }

    public function test_user_can_get_topic(): void
    {
        $user = User::factory()
            ->has(ModelTopic::factory())
            ->create();

        $topic = $user->topics[0];

        $response = $this->actingAs($user)
            ->get( route('topic.get', ['id' => $topic->id]) );

        $response->assertStatus(200)
            ->assertViewIs('topic')
            ->assertViewHasAll(['topic', 'numberOfComments']);
    }

    public function test_user_can_view_create_topic_form(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('topic.create'));

        $response->assertStatus(200)
            ->assertViewIs('topic-create');
    }

    public function test_user_can_create_topic_with_correct_credentials(): void
    {
        $user = User::factory()
            ->has(ModelTopic::factory())
            ->create();

        $topic = $user->topics[0];

        $response = $this->actingAs($user)
            ->post(route('topic.store', [
                'user_id' => $user->id,
                'name' => $topic->name,
                'text' => $topic->text,
            ]));

        $response->assertRedirect(route('topic.list'))
            ->assertSessionHas('topic-create-success');
    }

    public function test_user_cannot_create_topic_with_incorrect_credentials(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('topic.store', [
                'user_id' => null,
                'name' => null,
                'text' => null,
            ]));

        $response->assertRedirect(route('topic.list'))
            ->assertSessionHasErrors(['name']);
    }

    public function test_user_can_delete_own_topic(): void
    {
        $user = User::factory()
            ->has(ModelTopic::factory())
            ->create();

        $topic = $user->topics[0];


        $response = $this->actingAs($user)
            ->delete(route('topic.delete', [
                'user_id' => $user->id,
                'topic_id' => $topic->id,
            ]));

        $response->assertRedirect(route('topic.list'))
            ->assertSessionHas(['topic-delete-success']);
    }

    public function test_unauthorized_user_cannot_delete_not_his_topic(): void
    {
        $firstUser = User::factory()->create();

        $secondUser = User::factory()
            ->has(ModelTopic::factory())
            ->create();

        $secondUserTopic = $secondUser->topics[0];


        $response = $this->actingAs($firstUser)
            ->delete(route('topic.delete', [
                'topic_id' => $secondUserTopic->id,
            ]));

        $response->assertRedirect(route('topic.get', ['id' => $secondUserTopic->id]))
            ->assertSessionHasErrors(['topic-delete-faile']);
    }
}
