<?php

namespace Tests\Feature\Message;

use App\Models\Channel;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ManageTopicTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_create_a_topic(): void
    {
        $user = User::factory()->create();
        $channel = Channel::factory()->create([
            'organization_id' => $user->organization_id,
        ]);
        $user->channels()->attach($channel);

        $this->actingAs($user)
            ->post('/channels/' . $channel->id . '/topics', [
                'title' => 'Accounting',
                'content' => 'Accounting channel',
            ])
            ->assertStatus(302)
            ->assertRedirectToRoute('topic.show', [
                'channel' => $channel->id,
                'topic' => Topic::latest()->first()->id,
            ]);
    }

    /** @test */
    public function a_user_can_see_a_topic_if_he_is_part_of_the_channel(): void
    {
        $user = User::factory()->create();
        $channel = Channel::factory()->create([
            'organization_id' => $user->organization_id,
        ]);
        $topic = Topic::factory()->create([
            'channel_id' => $channel->id,
        ]);
        $user->channels()->attach($channel);

        $this->actingAs($user)
            ->get('/channels/' . $channel->id . '/topics/' . $topic->id)
            ->assertStatus(200);
    }

    /** @test */
    public function a_user_cant_see_a_topic_if_he_is_not_part_of_the_channel(): void
    {
        $user = User::factory()->create();
        $channel = Channel::factory()->create([
            'organization_id' => $user->organization_id,
            'is_public' => false,
        ]);
        $topic = Topic::factory()->create([
            'channel_id' => $channel->id,
        ]);

        $this->actingAs($user)
            ->get('/channels/' . $channel->id . '/topics/' . $topic->id)
            ->assertStatus(401);
    }
}
