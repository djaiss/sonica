<?php

namespace Tests\Unit\Services;

use App\Models\Topic;
use App\Models\User;
use App\Services\UpdateTopic;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UpdateTopicTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_updates_a_topic(): void
    {
        $user = User::factory()->create();
        $topic = Topic::factory()->create([
            'user_id' => $user->id,
        ]);
        $this->actingAs($user);

        $topic = (new UpdateTopic(
            topic: $topic,
            title: 'New title',
            content: 'New content',
        ))->execute();

        $this->assertInstanceOf(
            Topic::class,
            $topic
        );

        $this->assertDatabaseHas('topics', [
            'id' => $topic->id,
            'user_id' => $user->id,
            'title' => 'New title',
            'content' => 'New content',
        ]);
    }
}
