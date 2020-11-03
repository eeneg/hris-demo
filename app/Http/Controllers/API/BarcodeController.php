<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Barcode;
use App\Personalinformation;

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
        if (!Barcode::where('personalinformation_id', $request['id'])->exists()) {
            $employee = Personalinformation::findOrFail($request['id']);
        
            $code = $this->generateCode();
            while(Barcode::where('value', $code)->exists()){
                $code = $this->generateCode();
            }
            return Barcode::create([
                'personalinformation_id' => $employee->id,
                'value' => $code
            ]);
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
        $barcode = Barcode::where('value', $request->barcode)->where('personalinformation_id', $request->employee_id)->first();
        if ($barcode != null) {
            return Personalinformation::findOrFail($barcode->personalinformation_id);
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
