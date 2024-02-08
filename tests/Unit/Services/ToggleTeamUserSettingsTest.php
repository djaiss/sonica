<?php

namespace Tests\Unit\Services;

use App\Models\Team;
use App\Models\User;
use App\Services\ToggleTeamUserSettings;
use Exception;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ToggleTeamUserSettingsTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_updates_a_team(): void
    {
        $user = User::factory()->create();
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
        $this->actingAs($user);
        $team = (new ToggleTeamUserSettings(
            team: $team,
            settingsName: 'settings_team_show_actions',
        ))->execute();

        $this->assertInstanceOf(
            Team::class,
            $team
        );

        $this->assertTrue($user->fresh()->settings_team_show_actions);
    }
}
