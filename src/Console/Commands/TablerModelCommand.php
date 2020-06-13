<?php

declare(strict_types=1);

namespace Rizkhal\Tabler\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class TablerModelCommand extends GeneratorCommand
{
    use Concerns\Handler;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tabler:model 
                            {name : The name of the model.}
                            {--model-namespace= : The namespace of the model.}
                            {--table= : The name of the table.}
                            {--pk= : The name of the primarykey.}
                            {--relations= : The relationships for the model.}
                            {--accessor= : The accessor method for the model.}
                            {--mutator= : The mutator method for the model.}
                            {--soft-deletes= : Include soft deletes fields.}
                            {--force : Overwrite already existing model.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Model';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = "Model";

    /**
     * Build the class
     * 
     * @param  string $name
     * @return string
     */
    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());

        $ret = $this->replaceNamespace($stub, $name)
                    ->replaceSoftDeletes($stub)
                    ->replaceTableName($stub)
                    ->replacePrimaryKey($stub)
                    ->replaceAccessorName($stub)
                    ->replaceMutatorName($stub)
                    ->replaceRelations($stub)
                    ->replaceRelationshipPlaceholder($stub)
                    ->replaceClass($stub, $name);

        dd($ret);
    }

    /**
     * Replace the (optional) relationships part for the given stub.
     *
     * @param  string  $stub
     * @return self
     */
    protected function replaceRelations(&$stub): self
    {
        $relations = ! is_null($this->option('relations')) ? $this->option('relations') : [];

        foreach ($relations as $relation) {
            $parts = explode('#', $relation);
            if (count($parts) != 3) {
                continue;
            }

            $parts2 = explode('|', $parts[2]);

            $string = '';
            foreach ($parts2 as $key => $value) {
                $string .= "'".trim($value)."',";
            }

            $this->createRelationshipFunction($stub, trim($parts[0]), trim($parts[1]), $string);
        }

        return $this;
    }

    /**
     * Replace the (optional) soft deletes part for the given stub.
     *
     * @param  string  $stub
     * @return self
     */
    protected function replaceSoftDeletes(&$stub): self
    {
        if ($this->getOption('soft-deletes') == 'true') {
            $stub = str_replace('{{softDeletes}}', "use SoftDeletes;\n    ", $stub);
            $stub = str_replace('{{useSoftDeletes}}', "use Illuminate\Database\Eloquent\SoftDeletes;\n", $stub);
        } else {
            $stub = str_replace('{{softDeletes}}', '', $stub);
            $stub = str_replace('{{useSoftDeletes}}', '', $stub);
        }

        return $this;
    }

    /**
     * Replace the table for the given stub.
     *
     * @param  string  $stub
     * @return self
     */
    protected function replaceTableName(&$stub): self
    {
        $table = $this->getOption('table') ?: Str::plural(strtolower($this->argument('name')));

        $stub = str_replace('{{table}}', $table, $stub);

        return $this;
    }

    /**
     * Replace the primary key for the given stub
     * 
     * @param  string &$stub
     * @param  string $primaryKey
     * @return self 
     */
    protected function replacePrimaryKey(&$stub): self
    {
        $primaryKey = $this->getOption('pk');

        if (! is_null($primaryKey) || ! empty($primaryKey)) {
            $primaryKey = <<<EOD

            \t/**
            \t * The database primary key value.
            \t *
            \t * @var string
            \t */
            \tprotected \$primaryKey = '$primaryKey';

            EOD;
        }

        $incrementing = <<<EOD
        \t/**
        \t * Indicates if the IDs are auto-incrementing.
        \t *
        \t * @var bool
        \t */
        \tpublic \$incrementing = false;

        EOD;

        $increment = "{{incrementing}}";

        if (! is_null($primaryKey) || ! empty($primaryKey)) {
            $stub = str_replace($increment, "\n".$incrementing.$increment, $stub);
        }

        $stub = str_replace($increment, '', $stub);
        $stub = str_replace('{{primaryKey}}', $primaryKey, $stub);


        return $this;
    }

    /**
     * Replace accessor name fro the given stub
     * 
     * @param  string &$stub
     * @return self
     */
    protected function replaceAccessorName(&$stub): self
    {
        $accessorName = $this->getOption('accessor');

        $code = <<<EOD
        \t/**
        \t * Accessor for $accessorName
        \t *
        \t * @param string \$value
        \t */
        \tpublic function $accessorName(\$value)
        \t{
            \treturn \$value;
        \t}

        EOD;

        $str = '{{accessor}}';

        if (! is_null($accessorName) || ! empty($accessorName)) {
            $stub = str_replace($str, "\n".$code.$str, $stub);
        }

        $stub = str_replace($str, '', $stub);

        return $this;
    }

    /**
     * Replace mutator name fro the given stub
     * 
     * @param  string &$stub
     * @return self
     */
    protected function replaceMutatorName(&$stub): self
    {
        $mutatorName = $this->getOption('mutator');

        $code = <<<EOD
        \t/**
        \t * Mutator for $mutatorName
        \t *
        \t * @param string \$value
        \t */
        \tpublic function $mutatorName(\$value)
        \t{
            \t\$this->attributes['column'] = \$value;
        \t}

        EOD;

        $str = '{{mutator}}';

        if (! is_null($mutatorName) || ! empty($mutatorName)) {
            $stub = str_replace($str, "\n".$code.$str, $stub);
        }

        $stub = str_replace($str, '', $stub);

        return $this;
    }

    /**
     * Create relationships method for the given stub
     * 
     * @param  string &$stub
     * @param  string $relationName
     * @param  string $relationType
     * @param  string $string      
     * @return self
     */
    protected function createRelationshipFunction(&$stub, $relationName, $relationType, $string)
    {
        $to = str_replace("'", '', explode(',', $string)[0]);

        $code = <<<EOD

        \t/**
        \t * Relationships $relationType to $to.
        \t */
        \tpublic function $relationName()
        \t{
            \treturn \$this->$relationType($string);
        \t}

        EOD;

        $str = '{{relationships}}';

        $stub = str_replace($str, $code.$str, $stub);

        return $this;
    }

    /**
     * remove the relationships placeholder when it's no longer needed
     *
     * @param $stub
     * @return self
     */
    protected function replaceRelationshipPlaceholder(&$stub): self
    {
        $stub = str_replace('{{relationships}}', '', $stub);

        return $this;
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/Presents/tabler-crud-stubs/model.stub';
    }

    /**
     * Get default namespace 
     * 
     * @param  string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\\' . ($this->option('model-namespace') ? $this->option('model-namespace') : $rootNamespace);
    }
}
