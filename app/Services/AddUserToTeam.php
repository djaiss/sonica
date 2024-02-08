<?php

namespace App\Services;

use App\Models\Team;
use App\Models\User;
use Exception;

class AddUserToTeam extends BaseService
{
    public function __construct(
        public Team $team,
        public User $user,
    ) {
    }

    public function execute(): Team
    {
        $this->checkTeam();
        $this->add();

        return $this->team;
    }

    private function checkTeam(): void
    {
        if (! $this->team->users->contains(auth()->user()->id)) {
            throw new Exception(__('The user is not part of the team.'));
        }
    }

    private function add(): void
    {
        $this->team->users()->syncWithoutDetaching($this->user);
    }
}
