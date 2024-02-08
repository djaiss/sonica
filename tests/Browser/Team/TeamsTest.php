<?php

namespace Tests\Browser\Team;

use App\Models\Team;
use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TeamsTest extends DuskTestCase
{
    /** @test */
    public function a_user_can_crud_a_team(): void
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user): void {
            // create a team
            $browser->loginAs($user)
                ->visit('/teams')
                ->click('@add-team-cta')
                ->type('group-name', 'Accounting')
                ->radio('visibility', '0')
                ->click('@submit-form-button')
                ->assertPathIs('/teams/' . Team::latest()->first()->id)
                ->assertSee('Accounting');

            // edit the team
            $team = Team::orderBy('updated_at', 'desc')
                ->where('organization_id', $user->organization_id)
                ->first();

            $browser->visit('/teams/' . $team->id)
                ->waitFor('@edit-team')
                ->click('@edit-team')
                ->waitFor('@submit-form-button')
                ->type('group-name', 'Accounting team')
                ->radio('visibility', '0')
                ->type('description', 'This is the accounting team')
                ->waitFor('@submit-form-button')
                ->click('@submit-form-button')
                ->assertPathIs('/teams/' . $team->id)
                ->assertSee('Accounting team')
                ->assertSee('This is the accounting team');

            // delete the team
            $browser->visit('/teams/' . $team->id)
                ->waitFor('@delete-team')
                ->click('@delete-team')
                ->acceptDialog()
                ->pause(150)
                ->assertDontSee('Accounting team');
        });
    }
}
