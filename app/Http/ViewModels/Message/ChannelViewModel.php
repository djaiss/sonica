<?php

namespace App\Http\ViewModels\Message;

use App\Helpers\CacheHelper;
use App\Models\Channel;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class ChannelViewModel
{
    public static function show(Channel $channel): array
    {
        $topics = CacheHelper::get('user:{user-id}:channel:{channel-id}:topics', [
            'user-id' => auth()->user()->id,
            'channel-id' => $channel->id,
        ], 604800, function () use ($channel) {
            return $channel->topics()
                ->with('user')
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(fn (Topic $topic) => [
                    'id' => $topic->id,
                    'title' => $topic->title,
                    'content' => Str::words($topic->content, 20, '...'),
                    'user' => [
                        'avatar' => $topic->user->avatar,
                    ],
                    'created_at' => $topic->created_at->format('Y/m/d'),
                    'created_at_human_format' => $topic->created_at->diffForHumans(),
                    'url' => [
                        'show' => route('topic.show', [
                            'channel' => $channel->id,
                            'topic' => $topic->id,
                        ]),
                    ],
                ]);
        });

        // there is no need to cache the next query since the channel object comes from
        // the request, and the users relationship has already been added to
        // the request object. see CheckChannel.php.
        $users = $channel->users
            ->take(10)
            ->map(fn (User $user) => [
                'id' => $user->id,
                'name' => $user->name,
                'avatar' => $user->avatar,
                'url' => [
                    'show' => route('user.show', [
                        'user' => $user->id,
                    ]),
                ],
            ]);

        return [
            'id' => $channel->id,
            'name' => $channel->name,
            'description' => $channel->description,
            'is_public' => $channel->is_public,
            'topics' => $topics,
            'users' => $users,
            'url' => [
                'new' => route('topic.new', [
                    'channel' => $channel->id,
                ]),
                'edit' => route('channel.edit', [
                    'channel' => $channel->id,
                ]),
            ],
        ];
    }

    public static function edit(Channel $channel): array
    {
        return [
            'id' => $channel->id,
            'name' => $channel->name,
            'description' => $channel->description,
            'is_public' => $channel->is_public,
            'url' => [
                'show' => route('channel.show', [
                    'channel' => $channel->id,
                ]),
                'update' => route('channel.update', [
                    'channel' => $channel->id,
                ]),
                'destroy' => route('channel.destroy', [
                    'channel' => $channel->id,
                ]),
            ],
        ];
    }
}
