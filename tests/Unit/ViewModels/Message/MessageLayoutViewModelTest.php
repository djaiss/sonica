<?php

namespace Tests\Unit\ViewModels\Message;

use App\Http\ViewModels\Message\MessageLayoutViewModel;
use App\Models\Channel;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class MessageLayoutViewModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_gets_the_data_needed_for_the_list_of_channels(): void
    {
        $user = User::factory()->create();
        $channel = Channel::factory()->create([
            'organization_id' => $user->organization_id,
            'name' => 'Accounting',
            'is_public' => true,
        ]);
        $user->channels()->attach($channel);
        $this->actingAs($user);

        $array = MessageLayoutViewModel::index();

        $this->assertEquals(
            [
                0 => [
                    'id' => $channel->id,
                    'name' => 'Accounting',
                    'is_public' => true,
                    'url' => [
                        'show' => env('APP_URL') . '/channels/' . $channel->id,
                    ],
                ],
            ],
            $array['channels']->toArray()
        );
    }
}
