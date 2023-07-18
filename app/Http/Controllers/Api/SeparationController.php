<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Separation;
use App\Http\Resources\SeparationResource;

class SeparationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ($search = \Request::get('query')) {
            $separations = Separation::whereHas('personalinformation', function ($query) use ($search) {
                    $query->where('surname', 'LIKE', '%'.$search.'%')
                            ->orWhere('firstname', 'LIKE', '%'.$search.'%')
                            ->orWhere('middlename', 'LIKE', '%'.$search.'%');
                })->orderBy('effectivity_date', 'desc')->paginate(20);
        } else {
            $separations = Separation::orderBy('effectivity_date', 'desc')->paginate(20);
        }

        return new SeparationResource($separations);
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
