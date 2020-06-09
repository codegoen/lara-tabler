<?php

declare(strict_types=1);

namespace Rizkhal\Tabler\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class TablerModelCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tabler:model 
                            {name : The name of the model.}
                            {--table=? : The name of the table.}
                            {--pk=? : The name of the primarykey}
                            {--relations=? : The relationships for the model}
                            {--soft-deletes=? : Include soft deletes fields.}';

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
        return $rootNamespace;
    }

    /**
     * Build the class
     * 
     * @param  string $name [description]
     * @return string
     */
    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());
        $table = $this->getOption('table');
        $primaryKey = $this->getOption('pk');
        $relations = $this->getOption('relations') != '' ? explode(';', $this->getOption('relations')) : [];
        $softDeletes = $this->getOption('soft-deletes');

        if (! is_null($primaryKey) || !empty($primaryKey)) {
            $primaryKey = <<<EOD

            \t/**
            \t * The database primary key value.
            \t *
            \t * @var string
            \t */
            \tprotected \$primaryKey = '$primaryKey';

            EOD;
        }

        $ret = $this->replaceNamespace($stub, $name)
                    ->replaceSoftDeletes($stub, $softDeletes)
                    ->replaceTableName($stub, $table ?: Str::plural(strtolower($this->argument('name'))))
                    ->replacePrimaryKey($stub, $primaryKey);

        foreach ($relations as $relation) {
            // relationName#relationType#args_separated_by_pipes
            // e.g. employees#hasMany#App\Employee|id|dept_id
            // user is responsible for ensuring these relationships are valid
            $parts = explode('#', $relation);

            if (count($parts) != 3) {
                continue;
            }

            $args = explode('|', trim($parts[2]));
            $argsString = '';
            foreach ($args as $i => $v) {
                if (trim($v) == '') {
                    continue;
                }

                $argsString .= "'".trim($v)."', ";
            }

            $argsString = substr($argsString, 0, -2); // remove last comma

            $ret->createRelationshipFunction($stub, trim($parts[0]), trim($parts[1]), $argsString);
        }

        $ret->replaceRelationshipPlaceholder($stub);

        return $ret->replaceClass($stub, $name);
    }

    protected function createRelationshipFunction(&$stub, $relationName, $relationType, $string)
    {
        $code = <<<EOD

        \t/**
        \t * Relationships.
        \t */
        \tpublic function $relationName() {
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
     * @return $this
     */
    protected function replaceRelationshipPlaceholder(&$stub)
    {
        $stub = str_replace('{{relationships}}', '', $stub);
        return $this;
    }

    /**
     * Replace the (optional) soft deletes part for the given stub.
     *
     * @param  string  $stub
     * @param  string  $replaceSoftDelete
     *
     * @return $this
     */
    protected function replaceSoftDeletes(&$stub, $replaceSoftDelete)
    {
        if ($replaceSoftDelete == 'true') {
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
     * @param  string  $table
     *
     * @return $this
     */
    protected function replaceTableName(&$stub, $table)
    {
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
    protected function replacePrimaryKey(&$stub, $primaryKey): self
    {
        $stub = str_replace('{{primaryKey}}', $primaryKey, $stub);

        return $this;
    }

    /**
     * Get option
     * 
     * @param  string $option
     * @return string|void
     */
    protected function getOption(string $option)
    {
        if (! is_null($options = $this->option($option))) {
            return trim($options);
        }
    }
}