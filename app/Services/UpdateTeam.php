<?php

namespace App\Services;

use App\Models\Team;
use Exception;

class UpdateTeam extends BaseService
{
    public function __construct(
        public Team $team,
        public string $name,
        public ?string $description,
        public bool $isPublic,
    ) {
    }

    public function execute(): Team
    {
        $this->checkTeam();
        $this->update();
        $this->updateLastActiveAt();

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
        $this->team->update([
            'name' => $this->name,
            'description' => $this->description,
            'is_public' => $this->isPublic,
        ]);
    }

    private function updateLastActiveAt(): void
    {
        $this->team->update([
            'last_active_at' => now(),
        ]);
    }
}
