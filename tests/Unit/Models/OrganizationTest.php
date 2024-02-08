<?php

namespace Tests\Unit\Models;

use App\Models\Channel;
use App\Models\Level;
use App\Models\Organization;
use App\Models\Role;
use App\Models\Team;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class OrganizationTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_has_many_roles(): void
    {
        $organization = Organization::factory()->create();
        Role::factory()->create(['organization_id' => $organization->id]);

        $this->assertTrue($organization->roles()->exists());
    }

    /** @test */
    public function it_has_many_levels(): void
    {
        $organization = Organization::factory()->create();
        Level::factory()->create(['organization_id' => $organization->id]);

        $this->assertTrue($organization->levels()->exists());
    }

    /** @test */
    public function it_has_many_teams(): void
    {
        $organization = Organization::factory()->create();
        Team::factory()->create(['organization_id' => $organization->id]);

        $this->assertTrue($organization->teams()->exists());
    }

    /** @test */
    public function it_has_many_users(): void
    {
        $organization = Organization::factory()->create();
        User::factory()->create(['organization_id' => $organization->id]);

        $this->assertTrue($organization->users()->exists());
    }

    /** @test */
    public function it_has_many_channels(): void
    {
        $organization = Organization::factory()->create();
        Channel::factory()->create(['organization_id' => $organization->id]);

        $this->assertTrue($organization->channels()->exists());
    }

    /** @test */
    public function it_has_many_topics(): void
    {
        $organization = Organization::factory()->create();
        Topic::factory()->create(['organization_id' => $organization->id]);

        $this->assertTrue($organization->topics()->exists());
    }
}
