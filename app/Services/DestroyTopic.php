<?php

namespace App\Services;

use App\Models\Topic;

class DestroyTopic extends BaseService
{
    public function __construct(
        public Topic $topic,
    ) {
    }

    public function execute(): void
    {
        $this->destroy();
        $this->decrementTopicsCount();
    }

    public function destroy(): void
    {
        $this->topic->delete();
    }

    public function decrementTopicsCount(): void
    {
        $this->topic->channel->decrement('topics_count');
    }
}
