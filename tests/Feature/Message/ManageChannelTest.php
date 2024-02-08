<?php

namespace Tests\Feature\Message;

use App\Models\Channel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ManageChannelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_see_public_and_private_channels_he_belongs_to(): void
    {
        $channel = Channel::factory()->create([
            'name' => 'Accounting',
        ]);
        Channel::factory()->create([
            'name' => 'Engineering team',
            'organization_id' => $channel->organization_id,
            'is_public' => true,
        ]);
        Channel::factory()->create([
            'name' => 'Marketing team',
            'organization_id' => $channel->organization_id,
            'is_public' => false,
        ]);
        Channel::factory()->create([
            'name' => 'Sales team',
            'is_public' => true,
        ]);
        $user = User::factory()->create([
            'organization_id' => $channel->organization_id,
        ]);
        $user->channels()->attach($channel);

        $this->actingAs($user)
            ->get('/messages')
            ->assertSee('Accounting')
            ->assertDontSee('Engineering team')
            ->assertDontSee('Marketing team')
            ->assertDontSee('Sales team');
    }

    /** @test */
    public function a_user_can_see_a_private_channel_if_it_belongs_to_it(): void
    {
        $channel = Channel::factory()->create([
            'name' => 'Accounting',
            'is_public' => false,
        ]);
        $user = User::factory()->create([
            'organization_id' => $channel->organization_id,
        ]);
        $user->channels()->attach($channel);

        $this->actingAs($user)
            ->get('/channels/' . $channel->id)
            ->assertStatus(200);
    }

    /** @test */
    public function a_user_cant_see_any_channel_if_it_doesnt_belong_to_it(): void
    {
        $channel = Channel::factory()->create([
            'name' => 'Accounting',
            'is_public' => false,
        ]);
        $user = User::factory()->create([
            'organization_id' => $channel->organization_id,
        ]);

        $this->actingAs($user)
            ->get('/channels/' . $channel->id)
            ->assertStatus(401);
    }

    /** @test */
    public function a_user_can_create_a_channel(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('/channels', [
                'channel-name' => 'Accounting',
                'description' => 'Accounting channel',
                'visibility' => true,
            ])
            ->assertStatus(302)
            ->assertRedirectToRoute('channel.show', [
                'channel' => Channel::latest()->first()->id,
            ]);
    }

    /** @test */
    public function a_user_can_edit_a_channel(): void
    {
        $user = User::factory()->create();
        $channel = Channel::factory()->create([
            'organization_id' => $user->organization_id,
            'is_public' => false,
        ]);
        $user->channels()->attach($channel);

        $this->actingAs($user)
            ->put('/channels/' . $channel->id, [
                'channel-name' => 'Accounting',
                'description' => 'Accounting channel',
                'visibility' => true,
            ])
            ->assertStatus(302)
            ->assertRedirectToRoute('channel.edit', [
                'channel' => $channel->id,
            ]);
    }

    /** @test */
    public function a_user_can_delete_a_channel(): void
    {
        $user = User::factory()->create();
        $channel = Channel::factory()->create([
            'organization_id' => $user->organization_id,
        ]);
        $user->channels()->attach($channel);

        $this->actingAs($user)
            ->delete('/channels/' . $channel->id)
            ->assertStatus(200);

        $this->assertDatabaseMissing('channels', [
            'id' => $channel->id,
        ]);
    }
}
