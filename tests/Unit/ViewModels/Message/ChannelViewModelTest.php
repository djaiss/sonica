<?php

namespace Tests\Unit\ViewModels\Message;

use App\Http\ViewModels\Message\ChannelViewModel;
use App\Models\Channel;
use App\Models\Topic;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ChannelViewModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_gets_the_data_needed_for_displaying_the_channel(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        $user = User::factory()->create([
            'first_name' => 'John',
            'last_name' => 'Doe',
        ]);
        $channel = Channel::factory()->create([
            'organization_id' => $user->organization_id,
            'name' => 'Accounting',
            'description' => 'Accounting channel',
            'is_public' => true,
        ]);
        $topic = Topic::factory()->create([
            'channel_id' => $channel->id,
            'user_id' => $user->id,
            'title' => 'Topic title',
            'content' => 'Topic content',
            'created_at' => '2020-01-01 00:00:00',
        ]);
        $user->channels()->attach($channel);
        $this->actingAs($user);

        $array = ChannelViewModel::show($channel);

        $this->assertEquals(
            $channel->id,
            $array['id']
        );
        $this->assertEquals(
            'Accounting',
            $array['name']
        );
        $this->assertEquals(
            'Accounting channel',
            $array['description']
        );
        $this->assertTrue(
            $array['is_public']
        );
        $this->assertEquals(
            [
                'new' => env('APP_URL') . '/channels/' . $channel->id . '/topics/new',
                'edit' => env('APP_URL') . '/channels/' . $channel->id . '/edit',
            ],
            $array['url']
        );
        $this->assertEquals(
            [
                0 => [
                    'id' => $topic->id,
                    'title' => 'Topic title',
                    'content' => 'Topic content',
                    'user' => [
                        'avatar' => $user->avatar,
                    ],
                    'created_at' => '2020/01/01',
                    'created_at_human_format' => '2 years from now',
                    'url' => [
                        'show' => env('APP_URL') . '/channels/' . $channel->id . '/topics/' . $topic->id,
                    ],
                ],
            ],
            $array['topics']->toArray()
        );
        $this->assertEquals(
            [
                0 => [
                    'id' => $user->id,
                    'name' => 'John Doe',
                    'avatar' => $user->avatar,
                    'url' => [
                        'show' => env('APP_URL') . '/users/' . $user->id,
                    ],
                ],
            ],
            $array['users']->toArray()
        );
    }

    /** @test */
    public function it_gets_the_data_needed_for_editing_the_channel(): void
    {
        $channel = Channel::factory()->create([
            'name' => 'Accounting',
            'description' => 'Accounting channel',
            'is_public' => true,
        ]);

        $array = ChannelViewModel::edit($channel);

        $this->assertEquals(
            $channel->id,
            $array['id']
        );
        $this->assertEquals(
            'Accounting',
            $array['name']
        );
        $this->assertEquals(
            'Accounting channel',
            $array['description']
        );
        $this->assertTrue(
            $array['is_public']
        );
        $this->assertEquals(
            [
                'show' => env('APP_URL') . '/channels/' . $channel->id,
                'update' => env('APP_URL') . '/channels/' . $channel->id,
                'destroy' => env('APP_URL') . '/channels/' . $channel->id,
            ],
            $array['url']
        );
    }
}
