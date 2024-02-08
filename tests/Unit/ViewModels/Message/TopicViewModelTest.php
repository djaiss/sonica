<?php

namespace Tests\Unit\ViewModels\Message;

use App\Http\ViewModels\Message\TopicViewModel;
use App\Models\Channel;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class TopicViewModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_gets_the_data_needed_for_creating_a_topic(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create([
            'organization_id' => $user->organization_id,
            'first_name' => 'John',
            'last_name' => 'Doe',
        ]);
        $channel = Channel::factory()->create([
            'organization_id' => $user->organization_id,
            'name' => 'Accounting',
            'description' => 'Accounting channel',
            'is_public' => true,
        ]);
        $user->channels()->attach($channel);
        $otherUser->channels()->attach($channel);
        $this->actingAs($user);

        $array = TopicViewModel::new($channel);

        $this->assertEquals(
            $channel->id,
            $array['channel']['id']
        );
        $this->assertEquals(
            'Accounting',
            $array['channel']['name']
        );
        $this->assertEquals(
            [
                'show' => env('APP_URL') . '/channels/' . $channel->id,
                'store' => env('APP_URL') . '/channels/' . $channel->id . '/topics',
            ],
            $array['channel']['url']
        );
        $this->assertEquals(
            [
                1 => [
                    'id' => $otherUser->id,
                    'name' => 'John Doe',
                    'avatar' => $otherUser->avatar,
                    'url' => [
                        'show' => env('APP_URL') . '/users/' . $otherUser->id,
                    ],
                ],
            ],
            $array['channel']['users']->toArray()
        );
        $this->assertEquals(
            [
                'avatar' => $user->avatar,
            ],
            $array['user']
        );
    }

    /** @test */
    public function it_gets_the_data_needed_for_showing_a_topic(): void
    {
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
            'title' => 'Should we fire Henry?',
            'content' => 'He is a nuisance',
        ]);
        $user->channels()->attach($channel);
        $this->actingAs($user);

        $array = TopicViewModel::show($channel, $topic);

        $this->assertEquals(
            [
                'id' => $channel->id,
                'name' => 'Accounting',
                'url' => [
                    'show' => env('APP_URL') . '/channels/' . $channel->id,
                ],
            ],
            $array['channel']
        );
        $this->assertEquals(
            [
                'id' => $topic->id,
                'title' => 'Should we fire Henry?',
                'content' => 'He is a nuisance',
                'user' => [
                    'id' => $topic->user->id,
                    'name' => 'John Doe',
                    'avatar' => $topic->user->avatar,
                    'url' => [
                        'show' => env('APP_URL') . '/users/' . $topic->user->id,
                    ],
                ],
            ],
            $array['topic']
        );
        $this->assertEquals(
            [
                'avatar' => $user->avatar,
            ],
            $array['user']
        );
    }
}
