<?php

namespace Tests\Unit\Models;

use App\Models\Channel;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ChannelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_belongs_to_one_organization(): void
    {
        $channel = Channel::factory()->create();
        $this->assertTrue($channel->organization()->exists());
    }

    /** @test */
    public function it_belongs_to_one_user(): void
    {
        $channel = Channel::factory()->create();
        $this->assertTrue($channel->user()->exists());
    }

    /** @test */
    public function it_has_many_users(): void
    {
        $user = User::factory()->create();
        $channel = Channel::factory()->create();
        $user->channels()->attach($channel->id);

        $this->assertTrue($channel->users()->exists());
    }

    /** @test */
    public function it_has_many_topics(): void
    {
        $channel = Channel::factory()->create();
        Topic::factory()->create(['channel_id' => $channel->id]);

        $this->assertTrue($channel->topics()->exists());
    }
}
