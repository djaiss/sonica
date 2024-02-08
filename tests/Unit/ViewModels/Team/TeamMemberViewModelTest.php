<?php

namespace Tests\Unit\ViewModels\Team;

use App\Http\ViewModels\Team\TeamMemberViewModel;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class TeamMemberViewModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_gets_the_data_needed_for_the_index_view(): void
    {
        $user = User::factory()->create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@doe.com',
        ]);
        $team = Team::factory()->create([
            'organization_id' => $user->organization_id,
            'name' => 'Accounting',
        ]);
        $team->users()->attach($user);
        $this->actingAs($user);

        $collection = TeamMemberViewModel::index($team);

        $this->assertEquals(
            [
                0 => [
                    'id' => $user->id,
                    'name' => 'John Doe',
                    'avatar' => $user->avatar,
                    'can_destroy' => false,
                    'url' => [
                        'show' => env('APP_URL') . '/users/' . $user->id,
                        'destroy' => env('APP_URL') . '/teams/' . $team->id . '/members/' . $user->id,
                    ],
                ],
            ],
            $collection->toArray()
        );
    }

    /** @test */
    public function it_gets_the_data_needed_for_the_new_view(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create([
            'organization_id' => $user->organization_id,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@doe.com',
        ]);
        $team = Team::factory()->create([
            'organization_id' => $user->organization_id,
            'name' => 'Accounting',
        ]);
        $team->users()->attach($user);

        $array = TeamMemberViewModel::new($team);

        $this->assertEquals(
            $team->id,
            $array['team']['id']
        );
        $this->assertEquals(
            'Accounting',
            $array['team']['name']
        );
        $this->assertEquals(
            [
                0 => [
                    'id' => $otherUser->id,
                    'name' => 'John Doe',
                    'avatar' => $otherUser->avatar,
                    'email' => 'john@doe.com',
                    'url' => [
                        'store' => env('APP_URL') . '/teams/' . $team->id . '/members/' . $otherUser->id,
                    ],
                ],
            ],
            $array['team']['users']->toArray()
        );
    }
}
