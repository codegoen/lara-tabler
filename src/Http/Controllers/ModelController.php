<?php

namespace Rizkhal\Tabler\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Rizkhal\Tabler\Console\Commands\Exceptions\CommandException;

class ModelController extends Controller
{
    public function index()
    {
        return view('tabler::model');
    }

    public function create(Request $request)
    {
        try {
            $exit = Artisan::call("tabler:model", [
                "name" => $request->modelName,
                "--pk" => $request->primaryKey,
                "--table" => $request->tableName,
                "--relations" => $request->relations,
                "--accessor" => $request->accessor,
                "--soft-deletes" => $request->softDeletes
            ]);

            return redirect()->back();

        } catch (CommandException $e) {
            dd($e);
        }
    }
}
