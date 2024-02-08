<?php

namespace Tests\Browser\Team;

use App\Models\Team;
use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TeamMembersTest extends DuskTestCase
{
    /** @test */
    public function a_user_can_add_a_team_member(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create([
            'organization_id' => $user->organization_id,
            'first_name' => 'John',
            'last_name' => 'Doe',
        ]);
        $team = Team::factory()->create([
            'organization_id' => $user->organization_id,
        ]);
        $team->users()->attach($user);

        $this->browse(function (Browser $browser) use ($user, $team, $otherUser): void {
            $browser->loginAs($user)
                ->visit('/teams/' . $team->id)
                ->waitFor('@add-user-cta')
                ->click('@add-user-cta')
                ->waitFor('@user-candidate-' . $otherUser->id)
                ->assertSee('John Doe')
                ->click('@user-candidate-' . $otherUser->id)
                ->pause(150)
                ->assertSee('John Doe');
        });
    }

    /** @test */
    public function a_user_can_remove_a_team_member(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create([
            'organization_id' => $user->organization_id,
            'first_name' => 'John',
            'last_name' => 'Doe',
        ]);
        $team = Team::factory()->create([
            'organization_id' => $user->organization_id,
        ]);
        $team->users()->attach($user);
        $team->users()->attach($otherUser);

        $this->browse(function (Browser $browser) use ($user, $team, $otherUser): void {
            $browser->loginAs($user)
                ->visit('/teams/' . $team->id)
                ->waitFor('@remove-member-' . $otherUser->id)
                ->click('@remove-member-' . $otherUser->id)
                ->acceptDialog()
                ->pause(150)
                ->assertDontSee('John Doe');
        });
    }

    /** @test */
    public function a_team_member_cant_remove_himself_from_a_team(): void
    {
        $user = User::factory()->create();
        $team = Team::factory()->create([
            'organization_id' => $user->organization_id,
        ]);
        $team->users()->attach($user);

        $this->browse(function (Browser $browser) use ($user, $team): void {
            $browser->loginAs($user)
                ->visit('/teams/' . $team->id)
                ->assertNotPresent('@remove-member-' . $user->id);
        });
    }
}
