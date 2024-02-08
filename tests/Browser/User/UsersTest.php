<?php

namespace Tests\Browser\User;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UsersTest extends DuskTestCase
{
    /** @test */
    public function it_lists_all_the_users(): void
    {
        $user = User::factory()->create([
            'first_name' => 'Michael',
            'last_name' => 'Scott',
        ]);
        User::factory()->create([
            'first_name' => 'Dwight',
            'last_name' => 'Schrute',
            'organization_id' => $user->organization_id,
        ]);

        $this->browse(function (Browser $browser) use ($user): void {
            $browser->loginAs($user)
                ->visit('/users')
                ->assertSee('Michael Scott')
                ->assertSee('Dwight Schrute');
        });
    }

    /** @test */
    public function it_sees_a_user(): void
    {
        $user = User::factory()->create([
            'first_name' => 'Michael',
            'last_name' => 'Scott',
        ]);

        $this->browse(function (Browser $browser) use ($user): void {
            $browser->loginAs($user)
                ->visit('/users')
                ->click('@user-' . $user->id)
                ->assertSee('Michael Scott');
        });
    }
}
