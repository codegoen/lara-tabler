<?php

declare(strict_types=1);

namespace Rizkhal\Tabler\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Rizkhal\Tabler\Console\Commands\Exceptions\CommandException;

class CrudController extends Controller
{
    public function index()
    {
        return view('tabler::index');
    }

    public function create(Request $request)
    {
        //
    }
}
