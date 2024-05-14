<?php

namespace App\Http\Controllers\Api;

use App\Barcode;
use App\Http\Controllers\Controller;
use App\PersonalInformation;
use Illuminate\Http\Request;

class BarcodeController extends Controller
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
        $this->authorize('isAdministratorORAuthor');
        $employee = PersonalInformation::findOrFail($request['id']);
        $plantilla_content = $employee->plantillacontents->first();
        $barcode = Barcode::where('personal_information_id', $employee->id)->first();

        $date = $plantilla_content->last_promotion ? $plantilla_content->last_promotion : $plantilla_content->original_appointment;
        $code = str_replace('-', '', $date) . '-' . ($plantilla_content->new_number ? $plantilla_content->new_number : $plantilla_content->old_number);
        // while (Barcode::where('value', $code)->exists()) {
        //     $code = $this->generateCode();
        // }

        if ($barcode && $barcode->value != $code) {
            $barcode->update([
                'value' => $code
            ]);
            return [
                'barcode' => $code,
                'status' => 'updated',
            ];
        } else if ($barcode && $barcode->value == $code) {
            return [
                'barcode' => $code,
                'status' => 'exists',
            ];
        } else {
            Barcode::create([
                'personal_information_id' => $employee->id,
                'value' => $code,
            ]);
            return [
                'barcode' => $code,
                'status' => 'created',
            ];
        }
    }

    public function generateCode()
    {
        $code = '';
        for ($i = 0; $i < 12; $i++) {
            $code .= mt_rand(0, 9);
        }

        return $code;
    }

    public function verify(Request $request)
    {
        $barcode = Barcode::where('value', $request->barcode)->where('personal_information_id', $request->employee_id)->first();
        if ($barcode != null) {
            return PersonalInformation::with('plantillacontents')->findOrFail($barcode->personal_information_id);
        } else {
            return null;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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
