<?php

namespace Rizkhal\Tabler\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Rizkhal\Tabler\Console\Commands\Exceptions\CommandException;

class ControllerController extends Controller
{
    public function index()
    {
        return view('tabler::controller');
    }

    public function create(Request $request)
    {
        dd($request->all());
    }
}
