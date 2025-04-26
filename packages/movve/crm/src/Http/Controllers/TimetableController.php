<?php

namespace Movve\Crm\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TimetableController extends Controller
{
    public function index(Request $request)
    {
        return view('crm::timetable.index');
    }
}
