<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Position;
use App\Setting;
use App\Plantilla;
use App\PlantillaDept;
use App\Http\Resources\PositionQSResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('isAdministratorORAuthor');
        $positions = Position::without('department')->orderBy('title')->groupBy('title')->get();
        return $positions;

    }

    public function get_available_positions_for_QS(Request $request)
    {
        $this->authorize('isAdministratorORAuthor');

        if ($search = \Request::get('query')) {
            $positions = Position::without('department')
                ->where('title', 'LIKE', '%'.$search.'%')
                ->orderBy('positions.title')
                ->orderBy('positions.department_id')
                ->groupBy('positions.title')
                ->paginate(20);
        } else {
            $positions = Position::without('department')
                ->orderBy('positions.title')
                ->orderBy('positions.department_id')
                ->groupBy('positions.title')
                ->paginate(20);
        }

        return new PositionQSResource($positions);
    }

    public function get_department_positions(Request $request)
    {
        $this->authorize('isAdministratorORAuthor');
        $default_plantilla = Setting::where('title', 'Default Plantilla')->first();
        $plantilla = Plantilla::where('year', $default_plantilla->value)->first();
        $departments = PlantillaDept::where('plantilla_id', $plantilla->id)->orderBy('order_number')->get()->pluck('department');

        $positions = Position::without('department')->where('department_id', $request->department_id)->orderBy('title')->get();
        $allEmployees = DB::select("SELECT id, CONCAT(COALESCE(`surname`,''), ', ', COALESCE(`firstname`,''), ' ', COALESCE(`nameextension`,''), ' ', COALESCE(`middlename`,'')) AS `name` FROM personal_informations ORDER BY personal_informations.`surname`");
        $data = [
            'positions' => $positions,
            'allEmployees' => $allEmployees,
            'departments' => $departments
        ];

        return $data;
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
