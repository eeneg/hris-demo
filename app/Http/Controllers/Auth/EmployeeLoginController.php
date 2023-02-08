<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\PersonalInformation;
use App\Plantilla;
use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class EmployeeLoginController extends Controller
{
    public function index()
    {
    }

    public function employeelogin()
    {
        return view('employee_login.employee-login');
    }

    public function authenticateEmployeeLogin(Request $request)
    {
        $request->validate([
            'firstname' => 'required|exists:personal_informations,firstname',
            'surname' => 'required|exists:personal_informations,surname',
            'birthdate' => 'required|exists:personal_informations,birthdate',
        ]);

        $default_plantilla  =   Setting::where('title', 'Default Plantilla')->first();
        $plantilla          =   Plantilla::where('year', $default_plantilla->value)->first();

        $barcode = '';

        $employee = PersonalInformation::where('firstname', $request->firstname)
                        ->where('surname', $request->surname)
                        ->where('birthdate', $request->birthdate)
                        ->where('nameextension', $request->nameextension)
                        ->value('id');

        $ePlantilla = PersonalInformation::select('personal_informations.id')
        ->leftJoin('plantilla_contents', 'personal_informations.id', '=', 'plantilla_contents.personal_information_id')
        ->where('personal_informations.id', $employee)
        ->where('plantilla_contents.plantilla_id', $plantilla->id)
        ->first();

        if(! $ePlantilla)
        {
            return Redirect::back()->withErrors(['msg' => 'Employee not in Plantilla'])->withInput();
        }

        if (! $employee) {
            return Redirect::back()->withErrors(['msg' => 'Credentials not found'])->withInput();
        } else {
            $barcode = PersonalInformation::find($employee)->barcode;
        }

        if (! $barcode) {
            return Redirect::back()->withErrors(['barcode' => 'Employee does not have a barcode'])->withInput();
        } elseif ($employee && $barcode->value) {
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
            'barcode' => 'required|exists:barcodes,value',
        ]);

        if (session('barcode') != $request->barcode) {
            return Redirect::back()->withErrors(['barcode' => 'Invalid Barcode']);
        } else {
            Auth::guard('employee')->loginUsingId(session('id'));
            session()->forget('id');
            session()->forget('barcode');

            return redirect('/employees-pds-view');
        }
    }
}
