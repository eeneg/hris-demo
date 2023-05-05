<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Plantilla;
use App\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return match(filter_var($request->token, FILTER_VALIDATE_BOOL)) {
            true => [
                'dtr_token' => Setting::whereTitle('dtr_api_token')->first(['value'])->value,
                'dtr_url' => env('DTR_QUERY_URL'),
            ],
            default => [
                'plantilla' => Plantilla::where('year', Setting::whereTitle('Default Plantilla')->first(['value'])->value)->first(),
                'dtr_api_token' => Setting::whereTitle('dtr_api_token')->first(['value'])?->value ? true : null,
            ],
        };
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('isAdministrator');

        $this->validate($request, [
            'plantilla' => 'required',
            'dtr_api_token' => 'nullable|string'
        ]);

        Setting::firstOrCreate(['title' => 'Default Plantilla'])
            ->update(['value' => $request->plantilla['year']]);

        $request->whenFilled('dtr_api_token', function ($token) {
            Setting::firstOrCreate(['title' => 'dtr_api_token'], ['user_id' => auth()->user()->id])
                ->update(['value' => $token]);
        });

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
