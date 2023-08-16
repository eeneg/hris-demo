<?php

namespace App\Http\Controllers\Api;

use App\Department;
use App\Exports\PublicationExport;
use App\Http\Controllers\Controller;
use App\PlantillaContent;
use App\Publication;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class PublicationController extends Controller
{
    public function index()
    {
        return [
            'departments' => Department::active()->orderBy('title')->get(),
        ];
    }

    public function vacancies(Request $request)
    {
        $query = PlantillaContent::current()->vacant();

        if ($request->filled('search')) {
            $query->where(function ($query) use ($request) {
                $query->where('new_number', $request->search)
                    ->orWhere('old_number', $request->search)
                    ->orWhereHas('position', fn ($q) => $q->where('title', 'like', "%$request->search%"));
            });
        }

        if ($request->filled('office')) {
            $query->whereHas('position', fn ($q) => $q->where('department_id', $request->office));
        } else {
            $query->limit(15);
        }

        return $query->get();
    }

    public function create(Request $request)
    {
        return [
            'vacantPositions' => PlantillaContent::current()->vacant()->get(),
        ];
    }

    public function store(Request $request)
    {
        $request->validate([
            'vacancies' => 'required|array',
            'vacancies.*' => 'string|uuid|exists:plantilla_contents,id',
            'name' => 'required|string|max:255',
            'office' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'closing_date' => 'required|string|date:Y-m-d',
        ]);



        $publication = Publication::create([
            'name' => $name = "Publication of Vacant Positions " . now()->toFormattedDateString() . " - " . Carbon::parse($request->closing_date)->toFormattedDateString(),
            'office' => $request->office,
            'position' => $request->position,
            'address' => $request->address,
            'closing_date' => $request->closing_date,
            'file' => Str::kebab($name),
        ]);

        $publication->contents()->createMany(
            collect($request->vacancies)
                ->map(fn ($e) => ['plantilla_content_id' => $e])
                ->toArray()
        );

        $export = new PublicationExport($publication);

        return Excel::store($export, $name . '.xlsx');
    }

    public function destroy(Publication $publication, Request $request)
    {

    }
}
