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
                            {--model-name= : The name of the table.}
                            {--crud-name= : The name of the crud name.}
                            {--view-path= : The name of the directory crud path.}
                            {--request-name= : The name of the request name.}
                            {--route-group= : The name of the route group.}
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
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/Presents/tabler-crud-stubs/controller.stub';
    }

    /**
     * Get default namespace 
     * 
     * @param  string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . "\\Http\\Controllers";
    }

    public function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());

        $requestName = $this->getOption('request-name');
        $viewPathName = $this->getOption('view-path');
        $modelName = $this->getOption('model-name');
        $crudName = $this->getOption('crud-name');
        $groupName = $this->getOption('route-group');

        $ret = $this->replaceNamespace($stub, $name)
                    ->replaceRequestName($stub, $requestName)
                    ->replaceViewPathName($stub, $viewPathName)
                    ->replaceModelName($stub, $modelName)
                    ->replaceCrudNamePlural($stub, $crudName)
                    ->replaceCrudNameSingular($stub, $crudName)
                    ->replaceRouteGroup($stub, $groupName)
                    ->replaceClass($stub, $name);

        dd($ret);
    }

    protected function replaceRequestName(&$stub, $requestName): self
    {
        $stub = str_replace("{{requestName}}", $requestName, $stub);

        return $this;
    }

    protected function replaceViewPathName(&$stub, $viewPathName): self
    {
        $stub = str_replace("{{viewPathName}}", $viewPathName, $stub);

        return $this;
    }

    protected function replaceModelName(&$stub, $modelName): self
    {
        $stub = str_replace('{{modelName}}', $modelName, $stub);

        return $this;
    }

    protected function replaceCrudNamePlural(&$stub, $crudName): self
    {
        $stub = str_replace('{{crudNamePlural}}', Str::plural($crudName), $stub);

        return $this;
    }

    protected function replaceCrudNameSingular(&$stub, $crudName): self
    {
        $stub = str_replace('{{crudNameSingular}}', Str::singular($crudName), $stub);

        return $this;
    }

    protected function replaceRouteGroup(&$stub, $groupName): self
    {
        $stub = str_replace('{{routeGroup}}', $groupName, $stub);

        return $this;
    }
}
