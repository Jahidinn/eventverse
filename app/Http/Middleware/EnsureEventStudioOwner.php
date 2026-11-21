<?php

namespace App\Http\Middleware;

use App\Models\Event;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class EnsureEventStudioOwner
{
    public function handle(Request $request, Closure $next): Response
    {
        $eventParam = $request->route('event_id') ?? $request->route('event');

        if (!$eventParam) {
            return $next($request);
        }

        $event = $eventParam instanceof Event
            ? $eventParam
            : Event::where('event_id', $eventParam)->first();

        abort_if(!$event, 404);

        $user = $request->user();

        if (!$user) {
            abort(403);
        }

        abort_unless(Gate::forUser($user)->allows('update', $event), 403);

        return $next($request);
    }
}
