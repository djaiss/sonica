<?php

namespace Tests\Unit\Services;

use App\Models\Channel;
use App\Models\Topic;
use App\Services\DestroyTopic;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class DestroyTopicTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_destroys_a_topic(): void
    {
        $channel = Channel::factory()->create([
            'topics_count' => 2,
        ]);
        $topic = Topic::factory()->create([
            'channel_id' => $channel->id,
        ]);

        (new DestroyTopic(
            topic: $topic,
        ))->execute();

        $this->assertDatabaseMissing('topics', [
            'id' => $topic->id,
        ]);

        $this->assertDatabaseHas('channels', [
            'id' => $channel->id,
            'topics_count' => 1,
        ]);
    }
}
