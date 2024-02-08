<?php

namespace Tests\Unit\Services;

use App\Models\Team;
use App\Models\User;
use App\Services\AddUserToTeam;
use Exception;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AddUserToTeamTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_adds_a_user_to_a_team(): void
    {
        $user = User::factory()->create();
        $team = Team::factory()->create([
            'organization_id' => $user->organization_id,
        ]);
        $loggedUser = User::factory()->create([
            'organization_id' => $user->organization_id,
        ]);
        $loggedUser->teams()->attach($team);
        $this->executeService($team, $user, $loggedUser);
    }

    /** @test */
    public function it_fails_if_the_user_is_not_part_of_the_team(): void
    {
        $this->expectException(Exception::class);
        $user = User::factory()->create();
        $team = Team::factory()->create([
            'organization_id' => $user->organization_id,
        ]);
        $loggedUser = User::factory()->create([
            'organization_id' => $user->organization_id,
        ]);
        $this->executeService($team, $user, $loggedUser);
    }

    private function executeService(Team $team, User $user, User $loggedUser): void
    {
        $this->actingAs($loggedUser);
        $team = (new AddUserToTeam(
            team: $team,
            user: $user,
        ))->execute();

        $this->assertInstanceOf(
            Team::class,
            $team
        );

        $this->assertDatabaseHas('team_user', [
            'team_id' => $team->id,
            'user_id' => $user->id,
        ]);
    }
}
