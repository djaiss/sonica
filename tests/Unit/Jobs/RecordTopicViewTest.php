<?php

namespace Tests\Unit\Jobs;

use App\Jobs\RecordTopicView;
use App\Models\Channel;
use App\Models\Topic;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class RecordTopicViewTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_records_a_visit_on_a_topic(): void
    {
        $topic = Topic::factory()->create();
        $channel = Channel::factory()->create();

        RecordTopicView::dispatch($channel->id, $topic->id);

        $this->assertDatabaseHas('topics', [
            'id' => $topic->id,
            'views_count' => 1,
        ]);

        $this->assertDatabaseHas('channels', [
            'id' => $topic->id,
            'topic_views_count' => 1,
        ]);
    }
}
