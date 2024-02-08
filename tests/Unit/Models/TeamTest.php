<?php

namespace Tests\Unit\Models;

use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class TeamTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_belongs_to_one_organization(): void
    {
        $team = Team::factory()->create();
        $this->assertTrue($team->organization()->exists());
    }

    /** @test */
    public function it_has_many_users(): void
    {
        $sales = Team::factory()->create();
        $dwight = User::factory()->create([
            'organization_id' => $sales->organization_id,
        ]);

        $sales->users()->syncWithoutDetaching([$dwight->id]);

        $this->assertTrue($sales->users()->exists());
    }
}
