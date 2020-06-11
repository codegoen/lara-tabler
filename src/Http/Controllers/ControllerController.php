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
        try {
            $exit = Artisan::call("tabler:controller", [
                "name" => $request->controllerName,
                "--model-name" => $request->modelName,
                "--crud-name" => $request->crudName,
                "--view-path" => $request->viewPath,
                "--request-name" => $request->requestName,
                "--route-group" => $request->routeGroup
            ]);

            return redirect()->back();

        } catch (CommandException $e) {
            dd($e);
        }
    }
}
