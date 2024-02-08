<?php

namespace App\Services;

use App\Models\Channel;

class UpdateChannel extends BaseService
{
    public function __construct(
        public Channel $channel,
        public string $name,
        public ?string $description,
        public bool $isPublic = true,
    ) {
    }

    public function execute(): Channel
    {
        $this->update();

        return $this->channel;
    }

    private function update(): void
    {
        $this->channel->update([
            'name' => $this->name,
            'description' => $this->description,
            'is_public' => $this->isPublic,
        ]);
    }
}
