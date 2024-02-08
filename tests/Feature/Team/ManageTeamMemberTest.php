<?php

namespace Tests\Feature\Team;

use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ManageTeamMemberTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_team_member_can_add_another_team_member_to_the_team(): void
    {
        $team = Team::factory()->create([
            'name' => 'Accounting',
        ]);
        $user = User::factory()->create([
            'organization_id' => $team->organization_id,
        ]);
        $team->users()->attach($user);

        $this->actingAs($user)
            ->get('/teams/' . $team->id)
            ->assertSee('Add a member');
    }

    /** @test */
    public function a_user_who_is_not_part_of_the_team_cant_add_another_team_member_to_the_team(): void
    {
        $team = Team::factory()->create([
            'name' => 'Accounting',
        ]);
        $user = User::factory()->create([
            'organization_id' => $team->organization_id,
        ]);

        $this->actingAs($user)
            ->get('/teams/' . $team->id)
            ->assertDontSee('Add a member');
    }
}
