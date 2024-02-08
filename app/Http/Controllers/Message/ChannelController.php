<?php

namespace App\Http\Controllers\Message;

use App\Http\Controllers\Controller;
use App\Http\ViewModels\Message\ChannelViewModel;
use App\Http\ViewModels\Message\MessageLayoutViewModel;
use App\Models\Channel;
use App\Services\CreateChannel;
use App\Services\DestroyChannel;
use App\Services\UpdateChannel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use Mauricius\LaravelHtmx\Http\HtmxResponseClientRedirect;

class ChannelController extends Controller
{
    public function new(): View
    {
        return view('message.channel.new');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'channel-name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'visibility' => 'required|boolean',
        ]);

        $channel = (new CreateChannel(
            name: $validated['channel-name'],
            description: $validated['description'],
            isPublic: $validated['visibility'],
        ))->execute();

        $request->session()->flash('status', __('The channel has been created'));

        Cache::forget('user:' . auth()->user()->id . ':channels');

        return redirect()->route('channel.show', [
            'channel' => $channel->id,
        ]);
    }

    public function show(Request $request): View
    {
        $channel = $request->attributes->get('channel');

        return view('message.channel.show', [
            'data' => [
                'layout' => MessageLayoutViewModel::index(),
                'channel' => ChannelViewModel::show($channel),
            ],
        ]);
    }

    public function edit(Request $request): View
    {
        $channel = $request->attributes->get('channel');

        return view('message.channel.edit', [
            'data' => ChannelViewModel::edit($channel),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'channel-name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'visibility' => 'required|boolean',
        ]);

        $channel = (new UpdateChannel(
            channel: $request->attributes->get('channel'),
            name: $validated['channel-name'],
            description: $validated['description'],
            isPublic: $validated['visibility'],
        ))->execute();

        $request->session()->flash('status', __('Changes saved'));

        Cache::forget('user:' . auth()->user()->id . ':channels');

        return redirect()->route('channel.edit', [
            'channel' => $channel->id,
        ]);
    }

    public function destroy(Request $request, Channel $channel): Response
    {
        (new DestroyChannel(
            channel: $channel,
        ))->execute();

        Cache::forget('user:' . auth()->user()->id . ':channels');
        Cache::forget('user' . auth()->user()->id . ':channel:' . $channel->id . ':topics');

        return new HtmxResponseClientRedirect(route('message.index'));
    }
}
