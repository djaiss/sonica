<?php

namespace App\Services;

use App\Models\Channel;

class CreateChannel extends BaseService
{
    private Channel $channel;

    public function __construct(
        public string $name,
        public ?string $description,
        public bool $isPublic = true,
    ) {
    }

    public function execute(): Channel
    {
        $this->create();
        $this->addCurrentUser();

        return $this->channel;
    }

    private function create(): void
    {
        $this->channel = Channel::create([
            'organization_id' => auth()->user()->organization_id,
            'user_id' => auth()->user()->id,
            'name' => $this->name,
            'description' => $this->description,
            'is_public' => $this->isPublic,
        ]);
    }

    private function addCurrentUser(): void
    {
        $this->channel->users()->syncWithoutDetaching([auth()->user()->id]);
    }
}
