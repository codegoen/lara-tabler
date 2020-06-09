<?php

declare(strict_types=1);

namespace Rizkhal\Tabler\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Rizkhal\Tabler\Console\Commands\Presents\TablerCrud;

class CrudGeneratorController extends Controller
{
    protected $crud;

    public function __construct(TablerCrud $crud)
    {
        $this->crud = $crud;
    }

    public function index()
    {
        return view('tabler::index');
    }

    public function create(Request $request)
    {
        dd($request->all());
        $this->crud->getRequest($request->all());
    }
}
