<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployeeLoginController extends Controller
{
    public function employeelogin() {
        return view('employee-login');
    }
}
