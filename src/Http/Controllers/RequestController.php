<?php

namespace Rizkhal\Tabler\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Rizkhal\Tabler\Console\Commands\Exceptions\CommandException;

class RequestController extends Controller
{
    public function index()
    {
        return view('tabler::request');
    }

    public function create(Request $request)
    {
        try {
            $exit = Artisan::call("tabler:request", [
                "name" => $request->requestName,
                "--authorized" => $request->authorized, 
                "--field-rules" => $request->fieldRules,
            ]);

            return redirect()->back();

        } catch (CommandException $e) {
            dd($e);
        }
    }
}
