<?php

namespace Tests\Unit\Models;

use App\Models\TopicNotification;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class TopicNotificationTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_belongs_to_one_user(): void
    {
        $topicNotification = TopicNotification::factory()->create();
        $this->assertTrue($topicNotification->user()->exists());
    }

    /** @test */
    public function it_belongs_to_one_topic(): void
    {
        $topicNotification = TopicNotification::factory()->create();
        $this->assertTrue($topicNotification->topic()->exists());
    }
}
