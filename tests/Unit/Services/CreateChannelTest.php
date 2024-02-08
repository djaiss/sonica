<?php

namespace Tests\Unit\Services;

use App\Models\Channel;
use App\Models\User;
use App\Services\CreateChannel;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CreateChannelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_creates_a_channel(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $channel = (new CreateChannel(
            name: 'My first channel',
            description: 'This is my first channel',
            isPublic: true,
        ))->execute();

        $this->assertInstanceOf(
            Channel::class,
            $channel
        );

        $this->assertDatabaseHas('channels', [
            'id' => $channel->id,
            'organization_id' => $user->organization_id,
            'user_id' => $user->id,
            'name' => 'My first channel',
            'description' => 'This is my first channel',
            'is_public' => true,
        ]);

        $this->assertDatabaseHas('channel_user', [
            'channel_id' => $channel->id,
            'user_id' => $user->id,
        ]);
    }
}
