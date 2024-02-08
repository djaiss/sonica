<?php

namespace Tests\Browser\Message;

use App\Models\Channel;
use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class MessageTest extends DuskTestCase
{
    /** @test */
    public function a_user_can_see_the_channels_he_belongs_to(): void
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

        $this->browse(function (Browser $browser) use ($user): void {
            $browser->loginAs($user)
                ->visit('/messages')
                ->assertSee('Accounting')
                ->assertDontSee('Engineering team')
                ->assertDontSee('Marketing team')
                ->assertDontSee('Sales team');
        });
    }

    /** @test */
    public function a_user_can_crud_a_public_channel(): void
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user): void {
            // channel creation
            $browser->loginAs($user)
                ->visit('/messages')
                ->waitFor('@add-channel-cta')
                ->click('@add-channel-cta')
                ->waitFor('@submit-form-button')
                ->type('channel-name', 'Accounting')
                ->type('description', 'Accounting team')
                ->radio('visibility', '1')
                ->click('@submit-form-button')
                ->assertPathIs('/channels/' . Channel::latest()->first()->id)
                ->assertSee('Accounting');

            // channel edition
            $browser->click('@channel-menu-options')
                ->click('@edit-channel-link')
                ->waitFor('@edit-form-button')
                ->type('channel-name', 'Accounting team')
                ->radio('visibility', '0')
                ->type('description', 'This is the accounting team')
                ->waitFor('@edit-form-button')
                ->click('@edit-form-button')
                ->assertPathIs('/channels/' . Channel::latest()->first()->id . '/edit')
                ->assertSee('Accounting team');

            // channel deletion
            $browser->visit('/channels/' . Channel::latest()->first()->id)
                ->click('@channel-menu-options')
                ->click('@delete-channel-link')
                ->click('@destroy-form-button')
                ->acceptDialog()
                ->pause(150)
                ->assertPathIs('/messages')
                ->assertDontSee('Accounting team');
        });
    }
}
