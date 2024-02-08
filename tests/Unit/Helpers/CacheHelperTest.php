<?php

namespace Tests\Unit\Helpers;

use App\Helpers\CacheHelper;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CacheHelperTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_gets_a_specific_cache_key(): void
    {
        $response = CacheHelper::get('team:{team-id}:users', ['team-id' => 1], 604800, function () {
            return 'test';
        });

        $this->assertEquals(
            'test',
            $response
        );
    }
}
