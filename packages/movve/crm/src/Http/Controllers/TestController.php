<?php

namespace Movve\Crm\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TestController extends Controller
{
    /**
     * Een eenvoudige test functie om te controleren of de route werkt.
     */
    public function test(Request $request, $id)
    {
        return "Test route werkt! Team ID: " . $id;
    }
}
