<?php

namespace Tests\Unit\ViewModels\User;

use App\Http\ViewModels\User\UserViewModel;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserViewModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_gets_the_data_needed_for_the_index_view(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $array = UserViewModel::index();

        $this->assertCount(1, $array);
        $this->assertArrayHasKey('users', $array);
    }

    /** @test */
    public function it_gets_the_user_object(): void
    {
        $user = User::factory()->create([
            'first_name' => 'Eric',
            'last_name' => 'Schmidt',
        ]);
        $array = UserViewModel::user($user);

        $this->assertCount(2, $array);
        $this->assertEquals(
            [
                'id' => $user->id,
                'name' => 'Eric Schmidt',
            ],
            $array
        );
    }

    /** @test */
    public function it_gets_the_data_needed_for_the_show_view(): void
    {
        $user = User::factory()->create([
            'first_name' => 'Eric',
            'last_name' => 'Schmidt',
        ]);

        $array = UserViewModel::show($user);

        $this->assertCount(2, $array);
        $this->assertEquals(
            [
                'id' => $user->id,
                'name' => 'Eric Schmidt',
            ],
            $array
        );
    }
}
