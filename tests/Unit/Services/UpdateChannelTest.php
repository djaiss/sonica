<?php

namespace Tests\Unit\Services;

use App\Models\Channel;
use App\Models\User;
use App\Services\UpdateChannel;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UpdateChannelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_updates_a_channel(): void
    {
        $user = User::factory()->create();
        $channel = Channel::factory()->create([
            'user_id' => $user->id,
        ]);
        $this->actingAs($user);

        $channel = (new UpdateChannel(
            channel: $channel,
            name: 'New title',
            description: 'New content',
            isPublic: false,
        ))->execute();

        $this->assertInstanceOf(
            Channel::class,
            $channel
        );

        $this->assertDatabaseHas('channels', [
            'id' => $channel->id,
            'user_id' => $user->id,
            'name' => 'New title',
            'description' => 'New content',
            'is_public' => false,
        ]);
    }
}
