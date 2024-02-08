<?php

namespace Tests\Unit\Services;

use App\Models\Channel;
use App\Models\Topic;
use App\Models\User;
use App\Services\CreateTopic;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CreateTopicTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_creates_a_topic(): void
    {
        $user = User::factory()->create();
        $channel = Channel::factory()->create([
            'organization_id' => $user->organization_id,
        ]);
        $this->actingAs($user);

        $topic = (new CreateTopic(
            channel: $channel,
            title: 'My first topic',
            content: 'This is my first topic',
        ))->execute();

        $this->assertInstanceOf(
            Topic::class,
            $topic
        );

        $this->assertDatabaseHas('topics', [
            'id' => $topic->id,
            'organization_id' => $user->organization_id,
            'channel_id' => $channel->id,
            'user_id' => $user->id,
            'title' => 'My first topic',
            'content' => 'This is my first topic',
        ]);

        $this->assertDatabaseHas('channels', [
            'id' => $channel->id,
            'topics_count' => 1,
        ]);
    }
}
