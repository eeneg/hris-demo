<?php

namespace App\Http\Controllers\Api;

use App\Activity;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        return Activity::query()
            ->with('user:id,name,avatar')
            ->when($request->filled('type'), function ($query) use ($request) {
                $query->whereType($request->type)
                    ->when(
                        $request->type === 'event',
                        fn ($query) => $query->latest('time')->when($request->filled('upcoming'), fn ($q) => $q->whereDate('time', '>=', now())),
                        fn ($query) => $query->latest('created_at')
                    );
            })
            ->when(
                $request->filled('query'),
                fn ($q) => $q->whereHas('user', fn ($q) => $q->whereName($request->query('query')))
                    ->orWhere('title', 'like', '%' . $request->query('query') . '%')
                    ->orWhere('info', 'like', '%' . $request->query('query') . '%')
            )->take(20)
            ->paginate()
            ->through(fn ($activity) => [
                'id' => $activity->id,
                'info' => $activity->info,
                'time' => $activity->time,
                'title' => $activity->title,
                'type' => $activity->type,
                'user' => [
                    'name' => $activity->user?->name,
                    'avatar' => $activity->user?->avatar,
                ],
                'created_at' => $activity->created_at,
            ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:120',
            'info' => 'nullable|string',
            'type' => 'required|string|in:announcement,event',
            'time' =>  'exclude_if:type,announcement|required_if:type,event|date:Y-m-d H:i',
        ]);

        Activity::make($validated)
            ->forceFill(['type' => $request->type, 'user_id' => $request->user()->id])
            ->save();
    }

    public function show(Activity $activity)
    {
        return compact('activity');
    }

    public function update(Request $request, Activity $activity)
    {
        $activity->update($request->validate([
            'title' => 'required|string|max:120',
            'info' => 'required|string',
            'time' => 'nullable|date:Y-m-d H:i',
        ]));
    }

    public function destroy(Activity $activity)
    {
        $activity->delete();
    }
}
