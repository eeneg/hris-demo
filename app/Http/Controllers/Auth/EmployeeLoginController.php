<?php

namespace App\Http\Controllers\Auth;

use App\PersonalInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;


class EmployeeLoginController extends Controller
{
    // public function index()
    // {
    //     $employee = PersonalInformation::find(Auth::guard('employee')->user()->id);

    //     return $employee;

    //     // return view('employee_login.employee-pds', compact('employee'));
    // }

    public function employeelogin ()
    {
        return view('employee_login.employee-login');
    }

    public function authenticateEmployeeLogin(Request $request)
    {
        $request->validate([
            'firstname' => 'required|exists:personal_informations,firstname',
            'surname'   => 'required|exists:personal_informations,surname',
            'birthdate' => 'required|exists:personal_informations,birthdate'
        ]);

        $employee = PersonalInformation::where('firstname', $request->firstname)
                        ->where('surname', $request->surname)
                        ->where('birthdate', $request->birthdate)
                        ->Where('nameextension', $request->nameextension)->value('id');

        $barcode = PersonalInformation::find($employee)->barcode;

        if(!$employee){
            abort(404, 'Crendentials not found');
        }else if(!$barcode){
            dd($employee);
            abort(403, 'Employee does not have a bacode');
        }else if($employee && $barcode->value){
            session(['id' => $employee, 'barcode' => $barcode->value]);
            return redirect()->route('step-two');
        }
    }

    public function employeeloginbarcode()
    {
        return view('employee_login.employee-login-barcode');
    }

    public function authenticateEmployeeLoginBarcode(Request $request)
    {

        $request->validate([
            'barcode' => 'required|exists:barcodes,value'
        ]);

        if(session('barcode') != $request->barcode)
        {
            abort(403, 'Invalid Barcode');
        }else{
            Auth::guard('employee')->loginUsingId(session('id'));
            return redirect('/employees-pds-view');
        }
    }
}
