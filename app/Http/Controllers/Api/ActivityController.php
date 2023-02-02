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
            ->with('user:name,avatar')
            ->when(
                $request->filled('query'),
                fn ($q) => $q->whereHas('user', fn ($q) => $q->whereName($request->query('query')))
                    ->orWhere('title', 'like', '%' . $request->query('query') . '%')
                    ->orWhere('info', 'like', '%' . $request->query('query') . '%')
            )->take(20)
            ->get()
            ->map(fn ($activity) => [
                'info' => $activity->info,
                'time' => $activity->time,
                'title' => $activity->title,
                'type' => $activity->type,
                'user' => [
                    'name' => $activity->user?->name,
                    'avatar' => $activity->user?->avatar,
                ],
            ]);
    }

    public function store(Request $request, string $type)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:120',
            'info' => 'nullable|string',
            'time' => 'nullable|date:Y-m-d H:i',
        ]);

        Activity::make($validated)->forceFill(['type' => $type, 'user_id' => $request->user()->id])->save();

        return back();
    }

    public function show(Activity $activity)
    {
        return compact('activity');
    }

    public function update(Request $request, Activity $activity)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:120',
            'info' => 'nullable|string',
            'time' => 'nullable|date:Y-m-d H:i',
        ]);

        $activity->update($validated);

        return back();
    }

    public function destroy(Activity $activity)
    {
        $activity->delete();

        return back();
    }
}
