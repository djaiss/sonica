<?php

namespace Tests\Unit\ViewModels\Settings;

use App\Http\ViewModels\Settings\SettingsProfileViewModel;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class SettingsProfileViewModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_gets_the_data_needed_for_the_index_view(): void
    {
        $user = User::factory()->create([
            'first_name' => 'Henri',
            'last_name' => 'Troyat',
            'email' => 'henri@troyat.com',
            'locale' => 'fr',
        ]);
        $this->actingAs($user);

        $array = SettingsProfileViewModel::index();

        $this->assertCount(4, $array);
        $this->assertEquals(
            [
                'first_name' => 'Henri',
                'last_name' => 'Troyat',
                'email' => 'henri@troyat.com',
                'locale' => 'fr',
            ],
            $array
        );
    }
}
