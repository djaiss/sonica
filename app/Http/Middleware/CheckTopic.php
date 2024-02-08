<?php

namespace App\Http\Middleware;

use App\Jobs\RecordTopicView;
use App\Models\Topic;
use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTopic
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $topic = Topic::where('channel_id', $request->attributes->get('channel')->id)
                ->with('user')
                ->findOrFail($request->route()->parameter('topic'));

            $request->attributes->add(['topic' => $topic]);

            RecordTopicView::dispatch(
                channelId: $request->attributes->get('channel')->id,
                topicId: $topic->id,
            );

            return $next($request);
        } catch (ModelNotFoundException) {
            abort(401);
        }
    }
}
