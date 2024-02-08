<?php

namespace App\Services;

use App\Models\Topic;

class UpdateTopic extends BaseService
{
    public function __construct(
        public Topic $topic,
        public string $title,
        public string $content,
    ) {
    }

    public function execute(): Topic
    {
        $this->update();

        return $this->topic;
    }

    private function update(): void
    {
        $this->topic->update([
            'title' => $this->title,
            'content' => $this->content,
        ]);
    }
}
