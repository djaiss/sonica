<?php

namespace App\Http\Controllers\Message;

use App\Http\Controllers\Controller;
use App\Http\ViewModels\Message\ChannelViewModel;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ChannelUserController extends Controller
{
    public function edit(Request $request): View
    {
        $channel = $request->attributes->get('channel');

        return view('message.channel.edit', [
            'data' => ChannelViewModel::edit($channel),
        ]);
    }
}
