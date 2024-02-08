<?php

namespace App\Http\ViewModels\User;

use App\Models\User;

class UserViewModel
{
    public static function index(): array
    {
        $users = User::where('organization_id', auth()->user()->organization_id)
            ->select('id', 'first_name', 'last_name', 'name_for_avatar')
            ->get()
            ->map(fn (User $user) => self::user($user))
            ->sortBy('name');

        return [
            'users' => $users,
        ];
    }

    public static function user(User $user): array
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
        ];
    }

    public static function show(User $user): array
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
        ];
    }
}
