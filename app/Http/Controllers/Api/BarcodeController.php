<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Barcode;
use App\PersonalInformation;

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
        if (!Barcode::where('personal_information_id', $request['id'])->exists()) {
            $employee = PersonalInformation::findOrFail($request['id']);

            $code = $this->generateCode();
            while(Barcode::where('value', $code)->exists()){
                $code = $this->generateCode();
            }
            return Barcode::create([
                'personal_information_id' => $employee->id,
                'value' => $code
            ]);
        } else {
            $data = [
                'barcode' => Barcode::where('personal_information_id', $request['id'])->first(),
                'status' => 'existing'
            ];
            return $data;
        }
    }

    public function generateCode(){
        $code = '';
        for($i = 0; $i < 12; $i++) {
             $code .= mt_rand(0, 9);
        }
        return $code;
    }

    public function verify(Request $request) {
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
