<?php

namespace App\Services;

use App\Models\Team;
use Exception;

class DestroyTeam extends BaseService
{
    public function __construct(
        public Team $team,
    ) {
    }

    public function execute(): void
    {
        $this->checkTeam();
        $this->destroy();
    }

    public function destroy(): void
    {
        $this->team->delete();
    }

    private function checkTeam(): void
    {
        if (! $this->team->users->contains(auth()->user()->id)) {
            throw new Exception(__('The user is not part of the team.'));
        }
    }
}
