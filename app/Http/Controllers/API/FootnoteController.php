<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Footnote;
use App\Plantilla;
use App\Setting;
use App\Department;

class FootnoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $default_plantilla = Setting::where('title', 'Default Plantilla')->first();
        $plantilla = Plantilla::where('year', $default_plantilla->value)->first();
        $department = Department::where('address', $request->department)->first();

        $footnote = Footnote::where('plantilla_id', $plantilla->id)->where('department_id', $department->id)->first();
        if ($footnote) {
            $footnote->note = $request->footnote;
            $footnote->save();
            return $footnote;
        } else {
            $newfn = Footnote::create([
                'plantilla_id' => $plantilla->id,
                'department_id' => $department->id,
                'note' => $request->footnote
            ]);
            return $newfn;
        }
    }

    public function getfootnote(Request $request) {
        $default_plantilla = Setting::where('title', 'Default Plantilla')->first();
        $plantilla = Plantilla::where('year', $default_plantilla->value)->first();
        $department = Department::where('address', $request->department)->first();

        return Footnote::where('plantilla_id', $plantilla->id)->where('department_id', $department->id)->first();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
