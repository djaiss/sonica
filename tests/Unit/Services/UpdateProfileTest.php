<?php

namespace Tests\Unit\Services;

use App\Models\User;
use App\Services\UpdateProfile;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class UpdateProfileTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_updates_the_information_of_the_user(): void
    {
        Event::fake();

        $user = User::factory()->create();
        $this->be($user);

        (new UpdateProfile(
            firstName: 'michael',
            lastName: 'scott',
            email: 'michael@dunder.com',
            locale: 'en',
        ))->execute();

        $this->assertDatabaseHas('users', [
            'id' => auth()->user()->id,
            'first_name' => 'michael',
            'last_name' => 'scott',
            'locale' => 'en',
        ]);

        Event::assertDispatched(Registered::class);
    }
}
