<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\ViewModels\Settings\SettingsProfileViewModel;
use App\Models\User;
use App\Services\UpdateProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingsProfileController extends Controller
{
    public function index(): View
    {
        return view('settings.profile.index', [
            'data' => SettingsProfileViewModel::index(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $rules = [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
            ],
            'locale' => ['required', 'string', 'max:2'],
        ];

        if (auth()->user()->email !== $request->email) {
            $rules['email'][] = 'unique:' . User::class;
        }

        $validated = $request->validate($rules);

        (new UpdateProfile(
            firstName: $validated['first_name'],
            lastName: $validated['last_name'],
            email: $validated['email'],
            locale: $validated['locale'],
        ))->execute();

        $request->session()->flash('status', __('Changes saved'));

        return redirect()->route('settings.profile.index');
    }
}
