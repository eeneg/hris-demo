<?php

namespace App\Http\Controllers\Api;

use App\Activity;
use App\ActivityAttachment;
use App\Http\Controllers\Controller;
use App\Http\Resources\ActivityResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        return new ActivityResource(
            Activity::query()
                ->with(['user:id,name,avatar', 'attachments'])
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
                )->paginate()
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:120',
            'info' => 'required|string',
            'type' => 'required|string|in:announcement,event',
            'time' =>  'exclude_if:type,announcement|required_if:type,event|date:Y-m-d H:i',
            'file.*' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        $act = Activity::create($validated);

        if($request->hasFile('file')){
            foreach($request->file('file') as $key => $file){
                $attachment = $act->attachments()->create([
                    'file_name' => $file->getClientOriginalName(),
                    'path' => 'storage/activity_attachments/',
                ]);
                Storage::disk('public')->putFileAs('activity_attachments/', $file, $attachment->id . '.' . $file->getClientOriginalExtension());
            }
        }

        $act->forceFill(['type' => $request->type, 'user_id' => $request->user()->id])->save();

    }

    public function show(Activity $activity)
    {
        $attachments = $activity->attachments;
        return compact('activity', 'attachments');
    }

    public function update(Request $request, Activity $activity)
    {

        $validated = $request->validate([
            'title' => 'required|string|max:120',
            'info' => 'nullable|string',
            'time' =>  'exclude_if:type,announcement|required_if:type,event|date:Y-m-d H:i',
        ]);

        if(count($request->deleteFiles) > 0){
            foreach($request->deleteFiles as $file){
                Storage::disk('public')->delete('activity_attachments/'.$file.'.pdf');
                $attachment = ActivityAttachment::find($file)->delete();
            }
        }

        $activity->update($validated);

    }

    public function uploadNewFilesOnEdit(Request $request)
    {
        $request->validate([
            'newFiles*' => 'file|mimes:pdf|max:2048'
        ]);

        if($request->hasFile('newFiles')){
            foreach($request->file('newFiles') as $key => $file){
                $attachment = Activity::find($request->id)->attachments()->create([
                    'file_name' => $file->getClientOriginalName(),
                    'path' => 'storage/activity_attachments/',
                ]);
                Storage::disk('public')->putFileAs('activity_attachments/', $file, $attachment->id . '.' . $file->getClientOriginalExtension());
            }
        }
    }

    public function destroy(Activity $activity)
    {
        $activity->attachments->each(function ($attachment) {
            Storage::disk('public')->delete('activity_attachments/' . $attachment->id . '.pdf');
            $attachment->delete();
        });

        $activity->delete();
    }
}
