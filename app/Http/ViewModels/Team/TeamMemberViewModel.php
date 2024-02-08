<?php

namespace App\Http\ViewModels\Team;

use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Collection;

class TeamMemberViewModel
{
    public static function index(Team $team): Collection
    {
        return $team->users()
            ->select('id', 'first_name', 'last_name', 'name_for_avatar')
            ->get()
            ->map(fn (User $user) => [
                'id' => $user->id,
                'name' => $user->name,
                'avatar' => $user->avatar,
                'can_destroy' => $user->id !== auth()->user()->id,
                'url' => [
                    'show' => route('user.show', [
                        'user' => $user->id,
                    ]),
                    'destroy' => route('team.member.destroy', [
                        'team' => $team->id,
                        'member' => $user->id,
                    ]),
                ],
            ]);
    }

    public static function new(Team $team): array
    {
        $usersInTeam = $team->users()->pluck('id')->toArray();

        $newUsers = $team->organization->users()
            ->whereNotIn('id', $usersInTeam)
            ->select('id', 'first_name', 'last_name', 'name_for_avatar', 'email')
            ->get()
            ->map(fn (User $user) => [
                'id' => $user->id,
                'name' => $user->name,
                'avatar' => $user->avatar,
                'email' => $user->email,
                'url' => [
                    'store' => route('team.member.store', [
                        'team' => $team->id,
                        'member' => $user->id,
                    ]),
                ],
            ]);

        return [
            'team' => [
                'id' => $team->id,
                'name' => $team->name,
                'users' => $newUsers,
            ],
        ];
    }
}
