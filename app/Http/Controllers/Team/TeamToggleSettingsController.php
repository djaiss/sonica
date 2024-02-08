<?php

namespace App\Http\Controllers\Team;

use App\Http\Controllers\Controller;
use App\Services\ToggleTeamUserSettings;
use Illuminate\Http\Request;

class TeamToggleSettingsController extends Controller
{
    public function update(Request $request, int $teamId, string $setting): void
    {
        $team = $request->attributes->get('team');

        $team = (new ToggleTeamUserSettings(
            team: $team,
            settingsName: $setting,
        ))->execute();
    }
}
