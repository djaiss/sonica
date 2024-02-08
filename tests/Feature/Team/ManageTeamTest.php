<?php

namespace Tests\Feature\Team;

use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ManageTeamTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_lists_teams(): void
    {
        $team = Team::factory()->create([
            'name' => 'Accounting',
        ]);
        $user = User::factory()->create([
            'organization_id' => $team->organization_id,
        ]);

        $this->actingAs($user)
            ->get('/teams')
            ->assertSee('Accounting');
    }

    /** @test */
    public function a_user_can_create_a_team(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('/teams', [
                'group-name' => 'Accounting',
                'visibility' => false,
            ])
            ->assertStatus(302)
            ->assertRedirectToRoute('team.show', ['team' => Team::latest()->first()->id]);
    }

    /** @test */
    public function a_user_can_update_a_team(): void
    {
        $user = User::factory()->create();
        $team = Team::factory()->create([
            'organization_id' => $user->organization_id,
        ]);
        $user->teams()->attach($team);

        $this->actingAs($user)
            ->put('/teams/' . $team->id, [
                'group-name' => 'Accounting',
                'visibility' => false,
                'description' => 'This is the accounting team',
            ])
            ->assertStatus(302)
            ->assertRedirectToRoute('team.show', ['team' => Team::latest()->first()->id]);
    }

    /** @test */
    public function a_user_can_delete_a_team(): void
    {
        $user = User::factory()->create();
        $team = Team::factory()->create([
            'organization_id' => $user->organization_id,
        ]);
        $user->teams()->attach($team);

        $this->actingAs($user)
            ->delete('/teams/' . $team->id)
            ->assertStatus(200);
    }

    /** @test */
    public function a_user_of_a_team_can_see_the_edit_or_delete_a_team_options(): void
    {
        $user = User::factory()->create();
        $team = Team::factory()->create([
            'organization_id' => $user->organization_id,
        ]);
        $user->teams()->attach($team);

        $this->actingAs($user)
            ->get('/teams/' . $team->id)
            ->assertSee('Edit team details');
    }

    /** @test */
    public function an_external_user_of_a_team_cant_edit_or_delete_a_team(): void
    {
        $user = User::factory()->create();
        $team = Team::factory()->create([
            'organization_id' => $user->organization_id,
        ]);

        $this->actingAs($user)
            ->get('/teams/' . $team->id)
            ->assertDontSee('Edit team details');
    }

    /** @test */
    public function an_external_user_of_a_team_cant_access_a_private_team(): void
    {
        $user = User::factory()->create();
        $team = Team::factory()->create([
            'organization_id' => $user->organization_id,
            'is_public' => false,
        ]);

        $this->actingAs($user)
            ->get('/teams/' . $team->id)
            ->assertStatus(401);
    }
}
