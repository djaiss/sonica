<?php

namespace Tests\Unit\Services;

use App\Models\Channel;
use App\Services\DestroyChannel;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class DestroyChannelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_destroys_a_channel(): void
    {
        $channel = Channel::factory()->create();

        (new DestroyChannel(
            channel: $channel,
        ))->execute();

        $this->assertDatabaseMissing('channels', [
            'id' => $channel->id,
        ]);
    }
}
