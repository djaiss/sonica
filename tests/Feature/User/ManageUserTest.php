<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ManageUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_cant_see_a_user_from_a_different_organization(): void
    {
        $user = User::factory()->create();
        $userFromAnotherOrganization = User::factory()->create();

        $this->actingAs($user)
            ->get('/users/' . $user->id)
            ->assertStatus(200);

        $this->actingAs($user)
            ->get('/users/' . $userFromAnotherOrganization->id)
            ->assertStatus(401);
    }
}
