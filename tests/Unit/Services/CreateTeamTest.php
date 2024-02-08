<?php

namespace Tests\Unit\Services;

use App\Models\Team;
use App\Models\User;
use App\Services\CreateTeam;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CreateTeamTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_creates_a_team(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        $user = User::factory()->create();
        $this->actingAs($user);
        $team = (new CreateTeam(
            name: 'Accounting',
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
            'last_active_at' => '2018-01-01 00:00:00',
        ]);

        $this->assertDatabaseHas('team_user', [
            'team_id' => $team->id,
            'user_id' => $user->id,
        ]);
    }
}
