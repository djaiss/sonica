<?php

namespace Tests\Unit\Services;

use App\Models\Team;
use App\Models\User;
use App\Services\UpdateTeam;
use Carbon\Carbon;
use Exception;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UpdateTeamTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_updates_a_team(): void
    {
        $user = User::factory()->create([
            'permissions' => User::ROLE_ACCOUNT_MANAGER,
        ]);
        $team = Team::factory()->create([
            'organization_id' => $user->organization_id,
        ]);
        $user->teams()->attach($team);
        $this->executeService($team, $user);
    }

    /** @test */
    public function it_fails_if_the_user_is_not_part_of_the_team(): void
    {
        $this->expectException(Exception::class);
        $user = User::factory()->create();
        $team = Team::factory()->create([
            'organization_id' => $user->organization_id,
        ]);
        $this->executeService($team, $user);
    }

    private function executeService(Team $team, User $user): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        $this->actingAs($user);
        $team = (new UpdateTeam(
            team: $team,
            name: 'Accounting',
            description: null,
            isPublic: false,
        ))->execute();

        $this->assertInstanceOf(
            Team::class,
            $team
        );

        $this->assertDatabaseHas('teams', [
            'id' => $team->id,
            'organization_id' => $user->organization_id,
            'name' => 'Accounting',
            'description' => null,
            'is_public' => false,
            'last_active_at' => '2018-01-01 00:00:00',
        ]);
    }
}
