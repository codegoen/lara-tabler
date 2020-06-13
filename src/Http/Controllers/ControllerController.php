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
                "--controller-namespace" => $request->controllerNamespace,
                "--model-name" => $request->modelName,
                "--model-namespace" => $request->modelNamespace,
                "--crud-name" => $request->crudName,
                "--view-path" => $request->viewPath,
                "--datatables" => $request->datatables,
                "--request-name" => $request->requestName
            ]);

            return redirect()->back();

        } catch (CommandException $e) {
            dd($e);
        }
    }
}
