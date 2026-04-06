<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Http\Controllers\Controller;

class ApplicationApiController extends Controller
{
    public function index(){
        $app = Application::orderBy('application_name')->get(['id', 'application_name']);

        return response()->json([
            'data' => $app,
        ]);
    }
}
