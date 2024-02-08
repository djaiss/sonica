<?php

namespace App\Http\Controllers\Team;

use App\Http\Controllers\Controller;
use App\Http\ViewModels\Team\TeamViewModel;
use App\Models\Team;
use App\Services\CreateTeam;
use App\Services\DestroyTeam;
use App\Services\UpdateTeam;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Mauricius\LaravelHtmx\Http\HtmxResponseClientRedirect;

class TeamController extends Controller
{
    public function index(): View
    {
        return view('team.index', [
            'data' => TeamViewModel::index(),
        ]);
    }

    public function new(): View
    {
        return view('team.new');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'group-name' => 'required|string|max:255',
            'visibility' => 'required|boolean',
        ]);

        $team = (new CreateTeam(
            name: $validated['group-name'],
            isPublic: $validated['visibility'],
        ))->execute();

        $request->session()->flash('status', __('The team has been created'));

        return redirect()->route('team.show', [
            'team' => $team->id,
        ]);
    }

    public function show(Request $request): View
    {
        $team = $request->attributes->get('team');
        $isPartOfTeam = $request->attributes->get('isPartOfTeam');

        return view('team.show', [
            'data' => TeamViewModel::show($team, $isPartOfTeam),
        ]);
    }

    public function edit(Request $request): View
    {
        $team = $request->attributes->get('team');

        return view('team.edit', [
            'data' => TeamViewModel::edit($team),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'group-name' => 'required|string|max:255',
            'visibility' => 'required|boolean',
            'description' => 'nullable|string|max:255',
        ]);

        $team = (new UpdateTeam(
            team: $request->attributes->get('team'),
            name: $validated['group-name'],
            isPublic: $validated['visibility'],
            description: $validated['description'],
        ))->execute();

        $request->session()->flash('status', __('Changes saved'));

        return redirect()->route('team.show', [
            'team' => $team->id,
        ]);
    }

    public function destroy(Request $request, Team $team): Response
    {
        (new DestroyTeam(
            team: $team,
        ))->execute();

        return new HtmxResponseClientRedirect(route('team.index'));
    }
}
