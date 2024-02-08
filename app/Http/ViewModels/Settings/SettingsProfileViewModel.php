<?php

namespace App\Http\ViewModels\Settings;

class SettingsProfileViewModel
{
    public static function index(): array
    {
        return [
            'first_name' => auth()->user()->first_name,
            'last_name' => auth()->user()->last_name,
            'email' => auth()->user()->email,
            'locale' => auth()->user()->locale,
        ];
    }
}
