<?php

namespace App\Http\Controllers\Message;

use App\Http\Controllers\Controller;
use App\Http\ViewModels\Message\TopicViewModel;
use App\Services\CreateTopic;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class TopicController extends Controller
{
    public function new(Request $request): View
    {
        $channel = $request->attributes->get('channel');

        return view('message.topic.new', [
            'data' => TopicViewModel::new($channel),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $channel = $request->attributes->get('channel');

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string|max:65535',
        ]);

        $topic = (new CreateTopic(
            channel: $channel,
            title: $validated['title'],
            content: $validated['content'] ?? null,
        ))->execute();

        $request->session()->flash('status', __('The topic has been created'));

        Cache::forget('user:' . auth()->user()->id . ':channel:' . $channel->id . ':topics');

        return redirect()->route('topic.show', [
            'channel' => $channel->id,
            'topic' => $topic->id,
        ]);
    }

    public function show(Request $request): View
    {
        $channel = $request->attributes->get('channel');
        $topic = $request->attributes->get('topic');

        return view('message.topic.show', [
            'data' => TopicViewModel::show($channel, $topic),
        ]);
    }
}
