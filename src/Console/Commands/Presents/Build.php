<?php

namespace Rizkhal\Tabler\Console\Commands\Presents;

abstract class Build
{
    protected function getStubs(string $filename): string
    {
        return file_get_contents(__DIR__."/tabler-crud-stubs/{$filename}.stub");
    }

    /**
     * Replace root namespace
     * 
     * @param  string &$contents
     * @param  string $rootNamespace
     * 
     * @return self
     */
    protected function replaceRootNamespace(string &$contents, string $rootNamespace): self
    {
        $contents = str_replace("{{rootNamespace}}", "App", $rootNamespace);

        return $this;
    }

    /**
     * Replace the namespace
     * 
     * @param  string &$contents
     * @param  string $namespace
     * 
     * @return self
     */
    protected function replaceNamespace(string &$contents, string $namespace): self
    {
        $contents = str_replace("{{namespace}}", "App", $contents);

        return $this;
    }

    /**
     * Replace the class name
     * 
     * @param  string &$contents
     * @param  string $class
     * 
     * @return self
     */
    protected function replaceClass(string &$contents, string $class): self
    {
        $contents = str_replace("{{class}}", $class, $contents);

        return $this;
    }

    protected function replaceModelName(string &$contents, string $modelName)
    {
        $contents = str_replace("{{modelName}}", $modelName, $contents);

        dump($contents);

        return $this;
    }

    /**
     * Replace the (optional) soft deletes part for the given stub.
     *
     * @param  string  $contents
     * @param  string  $softDeletes
     *
     * @return self
     */
    protected function replaceSoftDelete(&$contents, $softDeletes): self
    {
        $contents = str_replace('{{softDeletes}}', "use SoftDeletes;\n", $contents);
        $contents = str_replace('{{useSoftDeletes}}', "use Illuminate\Database\Eloquent\SoftDeletes;\n", $contents);

        return $this;
    }
}
