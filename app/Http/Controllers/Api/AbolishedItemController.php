<?php

namespace App\Http\Controllers\Api;

use App\AbolishedItem;
use App\Http\Controllers\Controller;
use App\Http\Resources\RevertItemResource;
use App\PlantillaContent;
use Illuminate\Http\Request;

class AbolishedItemController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $abolished_item = AbolishedItem::where('plantilla_content_id', $id)->first();

        return new RevertItemResource($abolished_item);
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
        $this->authorize('isAdministratorORAuthor');
        $abolished_item = AbolishedItem::findOrFail($id);
        $plantilla_content = PlantillaContent::findOrFail($abolished_item->plantillacontent->id);
        $plantilla_content->new_number = $abolished_item->new_number;
        $plantilla_content->salary_grade_prop_id = $abolished_item->salarygrade->id;
        $plantilla_content->save();
        $abolished_item->delete();

        // Update Item Numbers
        $contentUpdates = PlantillaContent::where('plantilla_id', $plantilla_content->plantilla->id)->where('order_number', '>', $plantilla_content->order_number)->get();
        foreach ($contentUpdates as $key => $value) {
            $value->new_number = $value->new_number != null ? intval($value->new_number) + 1 : $value->new_number;
            $value->save();
        }
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
