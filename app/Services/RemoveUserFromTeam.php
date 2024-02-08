<?php

namespace App\Services;

use App\Models\Team;
use App\Models\User;
use Exception;

class RemoveUserFromTeam extends BaseService
{
    public function __construct(
        public Team $team,
        public User $user,
    ) {
    }

    public function execute(): Team
    {
        $this->checkTeam();
        $this->remove();

        return $this->team;
    }

    private function checkTeam(): void
    {
        if (! $this->team->users->contains(auth()->user()->id)) {
            throw new Exception(__('The user is not part of the team.'));
        }

        if (! $this->team->users->contains($this->user->id)) {
            throw new Exception(__('The user is not part of the team.'));
        }
    }

    private function remove(): void
    {
        $this->team->users()->detach([$this->user->id]);
    }
}
