<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class RecordTopicView implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public int $channelId, public int $topicId)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        DB::table('topics')
            ->where('id', $this->topicId)
            ->increment('views_count');

        DB::table('channels')
            ->where('id', $this->channelId)
            ->increment('topic_views_count');
    }
}
