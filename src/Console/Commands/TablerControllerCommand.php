<?php

declare(strict_types=1);

namespace Rizkhal\Tabler\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Rizkhal\Tabler\Console\Commands\Presents\TablerAuth;

class TablerControllerCommand extends GeneratorCommand
{
    use Concerns\Handler;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tabler:controller 
                            {name : The name of the controller.}
                            {--controller-namespace= : The namespace of the controller.}
                            {--model-name= : The name of the table.}
                            {--model-namespace= : The namespace of the model.}
                            {--crud-name= : The name of the crud name.}
                            {--view-path= : The name of the directory crud path.}
                            {--request-name= : The name of the request name.}
                            {--route-group= : The name of the route group.}
                            {--datatables= : The datatables for list resources}
                            {--force : Overwrite already existing controller.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Controller';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = "Controller";

    /**
     * Build the class with the given name.
     *
     * @param string $name
     * @return string
     */
    public function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());

        return $this->replaceNamespace($stub, $name)
                    ->replaceRequestName($stub)
                    ->replaceModelName($stub)
                    ->replaceModelNamespace($stub)
                    ->replaceViewPathName($stub)
                    ->replaceUseDataTables($stub)
                    ->replaceCrudName($stub)
                    ->replaceClass($stub, $name);
    }

    protected function getCheckDataTable()
    {
        $dataTableClass = "App\\DataTables\\".$this->getOption('model-name')."DataTable";
        return $this->alreadyExists($dataTableClass);
    }

    protected function replaceUseDataTables(&$stub): self
    {
        $viewPath = $this->getOption('view-path'); 
        $modelName = $this->getOption('model-name');
        $modelNamespace = $this->getOption('model-namespace');
        $crudName = Str::plural($this->getOption('crud-name'));

        if (! is_null($this->getOption('datatables'))) {
            $test = $this->callSilent('datatables:make', [
                "name" => $modelName,
                "--model-namespace" => $modelNamespace,
                "--model",
            ]);

            $params = "{$modelName}DataTable \$dataTable";

            $dataTableClass = "App\\DataTables\\{$modelName}DataTable";

            $render = "return \$dataTable->render('$viewPath.index');";

            $stub = str_replace('{{dataTableParam}}', $params, $stub);
            $stub = str_replace('{{renderAble}}', $render, $stub);
            $stub = str_replace('{{useDataTables}}', "use $dataTableClass;\n", $stub);
        } else {

            $defaultRender = "return view('$viewPath.index', ['".$crudName."' => $modelName::latest()]);";

            $stub = str_replace('{{useDataTables}}', '', $stub);
            $stub = str_replace('{{dataTableParam}}', '', $stub);
            $stub = str_replace('{{renderAble}}', $defaultRender, $stub);
        }

        return $this;
    }

    /**
     * Replace the model namespace given from stub
     * 
     * @param  string &$stub
     * @return self
     */
    protected function replaceModelNamespace(&$stub)
    {
        $modelNamespace = $this->getOption('model-namespace');
        $lastChar = substr($modelNamespace, -1);

        if ($lastChar != '\\') {
            $modelNamespace .= '\\';
        }

        $stub = str_replace('{{modelNamespace}}', $modelNamespace, $stub);

        return $this;
    }

    /**
     * Replace the request name given from stub
     * 
     * @param  string &$stub
     * @return self
     */
    protected function replaceRequestName(&$stub): self
    {
        $stub = str_replace("{{requestName}}", $this->getOption('request-name'), $stub);

        return $this;
    }

    protected function replaceViewPathName(&$stub): self
    {
        $stub = str_replace("{{viewPathName}}", $this->getOption('view-path'), $stub);

        return $this;
    }

    protected function replaceModelName(&$stub): self
    {
        $stub = str_replace('{{modelName}}', $this->getOption('model-name'), $stub);

        return $this;
    }

    protected function replaceCrudName(&$stub): self
    {
        $crudName = $this->getOption('crud-name');

        $searches = [
            ['{{crudNameSingular}}', '{{crudNamePlural}}']
        ];

        foreach ($searches as $search) {
            $stub = str_replace(
                $search,
                [Str::singular($crudName), Str::plural($crudName)],
                $stub
            );
        }

        return $this;
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/Presents/tabler-crud-stubs/controller.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string $rootNamespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\\' . ($this->option('controller-namespace') ? $this->option('controller-namespace') : 'Http\Controllers');
    }
}
