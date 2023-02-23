<?php

namespace App\Http\Controllers\Api;

use App\Audit;
use App\Http\Controllers\Controller;
use App\Http\Resources\AuditResource;
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
        return new AuditResource(
            Audit::query()
                ->when($request->filled('query'), fn ($query) =>
                    $query->whereHas('user', fn ($query) => $query->where('name', 'like', '%' . $request->query('query') . '%'))
                        ->orWhere('auditable_type', 'like', 'App\\\\%' . $request->query('query') . '%')
                        ->orWhere('event', 'like', '%' . $request->query('query') . '%')
                        ->orWhere('ip_address', $request->query('query'))
                )->latest('created_at')
            ->paginate()
        );
    }
}
