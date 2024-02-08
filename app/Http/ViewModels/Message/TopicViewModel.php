<?php

namespace App\Http\ViewModels\Message;

use App\Models\Channel;
use App\Models\Topic;
use App\Models\User;

class TopicViewModel
{
    public static function new(Channel $channel): array
    {
        // get all the users in the channel, except the logged user
        $users = $channel->users
            ->filter(function ($user) {
                return $user->id !== auth()->user()->id;
            })
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
            'channel' => [
                'id' => $channel->id,
                'name' => $channel->name,
                'users' => $users,
                'url' => [
                    'show' => route('channel.show', [
                        'channel' => $channel->id,
                    ]),
                    'store' => route('topic.store', [
                        'channel' => $channel->id,
                    ]),
                ],
            ],
            'user' => [
                'avatar' => auth()->user()->avatar,
            ],
        ];
    }

    public static function show(Channel $channel, Topic $topic): array
    {
        return [
            'channel' => [
                'id' => $channel->id,
                'name' => $channel->name,
                'url' => [
                    'show' => route('channel.show', [
                        'channel' => $channel->id,
                    ]),
                ],
            ],
            'topic' => [
                'id' => $topic->id,
                'title' => $topic->title,
                'content' => $topic->content,
                'user' => [
                    'id' => $topic->user->id,
                    'name' => $topic->user->name,
                    'avatar' => $topic->user->avatar,
                    'url' => [
                        'show' => route('user.show', [
                            'user' => $topic->user->id,
                        ]),
                    ],
                ],
            ],
            'user' => [
                'avatar' => auth()->user()->avatar,
            ],
        ];
    }
}
