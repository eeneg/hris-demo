<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployeeHomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:employee');
    }

    public function index()
    {
        return redirect('/employees-pds-view');
    }
}
