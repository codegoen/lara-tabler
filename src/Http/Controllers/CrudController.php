<?php

namespace Rizkhal\Tabler\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Rizkhal\Tabler\Console\Commands\Exceptions\CommandException;

class CrudController extends Controller
{
    public function index()
    {
        return view('tabler::crud');
    }

    public function create(Request $request)
    {
        //
    }
}
