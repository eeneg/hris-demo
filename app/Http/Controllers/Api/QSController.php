<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\QS;
use App\Http\Resources\QSResource;

class QSController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ($search = \Request::get('query')) {
            $qs = QS::whereHas('position', function ($query) use ($search) {
                    $query->where('title', 'LIKE', '%'.$search.'%');
                })->leftJoin('positions', 'positions.id', '=', 'q_s.position_id')->orderBy('positions.title')->paginate(20);
        } else {
            $qs = QS::leftJoin('positions', 'positions.id', '=', 'q_s.position_id')
            ->orderBy('positions.title')->paginate(20);
        }

        // $qs = QS::paginate(20);
        return new QSResource($qs);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('isAdministratorORAuthor');

        $request->validate([
            'position_id' => 'required',
            'sg' => 'required',
            'education' => 'required',
            'experience' => 'required',
            'training' => 'required',
            'eligibility' => 'required',
        ]);

        $qs = QS::create($request->all());
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
        $this->authorize('isAdministratorORAuthor');

        $request->validate([
            'position_id' => 'required',
            'sg' => 'required',
            'education' => 'required',
            'experience' => 'required',
            'training' => 'required',
            'eligibility' => 'required',
        ]);

        $qs = QS::findOrFail($id);
        $qs->position_id = $request->position_id;
        $qs->sg = $request->sg;
        $qs->education = $request->education;
        $qs->experience = $request->experience;
        $qs->training = $request->training;
        $qs->eligibility = $request->eligibility;
        $qs->save();
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
