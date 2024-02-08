<?php

namespace App\Http\Controllers\Team;

use App\Http\Controllers\Controller;
use App\Http\ViewModels\Team\TeamMemberViewModel;
use App\Http\ViewModels\Team\TeamViewModel;
use App\Models\Team;
use App\Models\User;
use App\Services\AddUserToTeam;
use App\Services\RemoveUserFromTeam;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View as FacadesView;
use Illuminate\View\View;

class TeamMemberController extends Controller
{
    public function index(Request $request): ?View
    {
        $team = $request->attributes->get('team');

        if ($request->header('hx-request')) {
            return view('team.partials.user-list', [
                'data' => [
                    'team' => [
                        'users' => TeamMemberViewModel::index($team),
                        'is_part_of_team' => $request->attributes->get('isPartOfTeam'),
                    ],
                ],
            ]);
        }

        return null;
    }

    public function new(Request $request): ?View
    {
        $team = $request->attributes->get('team');

        if ($request->header('hx-request')) {
            return view('team.partials.user-new', [
                'data' => TeamMemberViewModel::new($team),
            ]);
        }

        return null;
    }

    public function store(Request $request, Team $team): string
    {
        $potentialMember = User::where('organization_id', auth()->user()->organization_id)
            ->where('id', $request->route()->parameter('member'))
            ->firstOrFail();

        $team = (new AddUserToTeam(
            team: $request->attributes->get('team'),
            user: $potentialMember,
        ))->execute();

        Cache::forget('team:' . $team->id . ':users');

        return FacadesView::renderFragment('team.show', 'user-list', [
            'data' => TeamViewModel::show($team, true),
        ]);
    }

    public function destroy(Request $request, Team $team, User $member): Response
    {
        try {
            User::where('organization_id', auth()->user()->organization_id)
                ->findOrFail($member->id);
        } catch (ModelNotFoundException) {
        }

        (new RemoveUserFromTeam(
            team: $team,
            user: $member,
        ))->execute();

        Cache::forget('team:' . $team->id . ':users');

        return response()->make('', 200, ['HX-Trigger' => 'loadMembers']);
    }
}
