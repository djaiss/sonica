<?php

namespace App\Services;

use App\Models\Team;

class CreateTeam extends BaseService
{
    private Team $team;

    public function __construct(
        public string $name,
        public bool $isPublic,
    ) {
    }

    public function execute(): Team
    {
        $this->create();
        $this->addCurrentUser();
        $this->updateLastActiveAt();

        return $this->team;
    }

    private function create(): void
    {
        $this->team = Team::create([
            'organization_id' => auth()->user()->organization_id,
            'name' => $this->name,
            'is_public' => $this->isPublic,
        ]);
    }

    private function addCurrentUser(): void
    {
        $this->team->users()->attach(auth()->user()->id);
    }

    private function updateLastActiveAt(): void
    {
        $this->team->update([
            'last_active_at' => now(),
        ]);
    }
}
