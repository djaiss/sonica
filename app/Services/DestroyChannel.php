<?php

namespace App\Services;

use App\Models\Channel;

class DestroyChannel extends BaseService
{
    public function __construct(
        public Channel $channel,
    ) {
    }

    public function execute(): void
    {
        $this->destroy();
    }

    public function destroy(): void
    {
        $this->channel->delete();
    }
}
