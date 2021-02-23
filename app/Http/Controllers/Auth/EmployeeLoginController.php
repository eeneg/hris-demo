<?php

namespace App\Http\Controllers\Auth;

use App\PersonalInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class EmployeeLoginController extends Controller
{
    public function index()
    {

    }

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

        $barcode = '';

        $employee = PersonalInformation::where('firstname', $request->firstname)
                        ->where('surname', $request->surname)
                        ->where('birthdate', $request->birthdate)
                        ->where('nameextension', $request->nameextension)
                        ->value('id');


        if(!$employee){
            return Redirect::back()->withErrors(['msg' => 'Credentials not found'])->withInput();
        }else{
            $barcode = PersonalInformation::find($employee)->barcode;
        }

        if(!$barcode){
            return Redirect::back()->withErrors(['barcode' => 'Employee does not have a barcode'])->withInput();
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
            return Redirect::back()->withErrors(['barcode' => 'Invalid Barcode']);
        }else{
            Auth::guard('employee')->loginUsingId(session('id'));
            session()->forget('id');
            session()->forget('barcode');
            return redirect('/employees-pds-view');
        }
    }
}
