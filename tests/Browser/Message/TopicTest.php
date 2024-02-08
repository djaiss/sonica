<?php

namespace Tests\Browser\Message;

use App\Models\Channel;
use App\Models\Topic;
use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TopicTest extends DuskTestCase
{
    /** @test */
    public function a_user_can_create_a_topic(): void
    {
        $user = User::factory()->create();
        $channel = Channel::factory()->create([
            'organization_id' => $user->organization_id,
        ]);
        $user->channels()->attach($channel);

        $this->browse(function (Browser $browser) use ($user, $channel): void {
            $browser->loginAs($user)
                ->visit('/channels/' . $channel->id)
                ->waitFor('@add-topic-cta')
                ->click('@add-topic-cta')
                ->waitFor('@submit-form-button')
                ->type('title', 'Awesome title of a post')
                ->type('content', 'A basic content')
                ->click('@submit-form-button')
                ->assertPathIs('/channels/' . $channel->id . '/topics/' . Topic::latest()->first()->id)
                ->assertSee('Awesome title of a post');
        });
    }
}
