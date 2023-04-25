<?php

namespace App\Http\Controllers\Api;

use App\Department;
use App\Drivers\PlantUml;
use App\Http\Controllers\Controller;
use App\OrganizationalUnit;
use App\PlantillaContent;
use Illuminate\Http\Request;

class OrganizationalUnitController extends Controller
{
    public function index()
    {
        return [
            'organizations' => OrganizationalUnit::root()->with('plantilla', 'department')->paginate(),
            'departments' => Department::all(),
        ];
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[\pL\s\-]+$/u',
                function ($attribute, $value, $fail) use ($request) {
                    if(
                        OrganizationalUnit::find($request->parent_id)
                            ?->bloodline()
                            ->where('name', $value)
                            ->orWhere('group', $value)
                            ->exists()
                    ) {
                        $fail('Name or group already exists. Please choose another.');
                    }
                },
            ],
            'group' => [
                'required',
                'string',
                'max:255',
                'regex:/^[\pL\s\-]+$/u',
                function ($attribute, $value, $fail) use ($request) {
                    if(
                        OrganizationalUnit::find($request->parent_id)
                            ?->bloodline()
                            ->where('name', $value)
                            ->orWhere('group', $value)
                            ->exists()
                    ) {
                        $fail('Name or group already exists. Please choose another.');
                    }
                },
            ],
            'department_id' => 'uuid|nullable|exists:departments,id',
            'plantilla_contents_id' => [
                'uuid',
                'exists:plantilla_contents,id',
                function ($attribute, $value, $fail) use ($request) {
                    if(
                        OrganizationalUnit::where('plantilla_contents_id', $value)
                            ->exists()
                    ) {
                        $fail('Plantilla already selected.');
                    };
                }
            ],
            'parent_id' => [
                'uuid',
                'nullable',
                'exists:organizational_units,id',
            ],
        ]);

        $org = OrganizationalUnit::make()->forceFill($validated);

        $org->save();
    }

    public function show(string $id)
    {
        return [
            'organization' => $org = OrganizationalUnit::find($id),
            'organizational_units' => $org->descendantsAndSelf()->with('plantilla')->get(),
            'plantilla' => PlantillaContent::whereHas('position.department', fn ($q) => $q->where('departments.id', $org->department_id))
                ->orderBy('order_number')
                ->get(),
            'plantuml' => (new PlantUml($org))->translate(),
            'descendants' => $org->descendants()->get()
        ];
    }

    public function update(Request $request, OrganizationalUnit $organizationalUnit)
    {
        //
    }

    public function destroy(OrganizationalUnit $organizationalUnit)
    {
        //
    }
}
