<?php

namespace App\Services;

use App\Models\Team;
use Exception;

class ToggleTeamUserSettings extends BaseService
{
    public function __construct(
        public Team $team,
        public string $settingsName,
    ) {
    }

    public function execute(): Team
    {
        $this->checkTeam();
        $this->update();

        return $this->team;
    }

    private function checkTeam(): void
    {
        if (! $this->team->users->contains(auth()->user()->id)) {
            throw new Exception(__('The user is not part of the team.'));
        }
    }

    private function update(): void
    {
        auth()->user()->{$this->settingsName} = ! auth()->user()->{$this->settingsName};
        auth()->user()->save();
    }
}
