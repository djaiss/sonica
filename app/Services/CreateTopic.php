<?php

namespace App\Services;

use App\Models\Channel;
use App\Models\Topic;
use Illuminate\Support\Facades\DB;

class CreateTopic extends BaseService
{
    private Topic $topic;

    public function __construct(
        public Channel $channel,
        public string $title,
        public ?string $content,
        public array $usersToNotify = [],
    ) {
    }

    public function execute(): Topic
    {
        $this->create();
        $this->incrementTopicsCount();
        $this->notifyUsers();

        return $this->topic;
    }

    private function create(): void
    {
        $this->topic = Topic::create([
            'organization_id' => auth()->user()->organization_id,
            'user_id' => auth()->user()->id,
            'channel_id' => $this->channel->id,
            'title' => $this->title,
            'content' => $this->content,
        ]);
    }

    private function incrementTopicsCount(): void
    {
        $this->channel->increment('topics_count');
    }

    /**
     * There are 3 types of notifications for a topic:
     * - all the users in the channel (except the current user)
     * - specific users (who should not be in the channel)
     * - no one specifically.
     */
    private function notifyUsers(): void
    {
        if (empty($this->usersToNotify)) {
            return;
        }

        foreach ($this->usersToNotify as $user) {
            DB::table('topic_notifications')->insert([
                'user_id' => $user->id,
                'topic_id' => $this->topic->id,
            ]);
        }
    }
}
