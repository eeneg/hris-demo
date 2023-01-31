<?php

namespace App\Http\Controllers\Api;

use App\Audit;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuditController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Audit::query()
            ->when($request->filled('query'), fn ($query) =>
                $query->whereHas('user', fn ($query) => $query->where('name', 'like', '%' . $request->query('query') . '%'))
                    ->orWhere('auditable_type', 'like', 'App\\\\%' . $request->query('query') . '%')
                    ->orWhere('event', 'like', '%' . $request->query('query') . '%')
                    ->orWhere('ip_address', $request->query('query'))
            )->latest('created_at')
            ->paginate(100)
            ->through(fn ($audit) => [
                'audited' => $audit->audited,
                'event' => $audit->event,
                'ip_address' => $audit->ip_address,
                'modified' => $audit->modified,
                'time' => $audit->created_at,
                'user' => [
                    'avatar' => $audit->user->avatar,
                    'name' => $audit->user->name,
                ],
            ]);
    }
}
