<?php

declare(strict_types=1);

namespace Rizkhal\Tabler\Console\Commands\Concern;

use Illuminate\Support\Str;

trait Build
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
        $contents = str_replace("{{rootNamespace}}", "App\\Http", $contents);

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
        $contents = str_replace("{{namespace}}", $namespace, $contents);

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

    protected function replaceBoolean(string &$contents, string $bool): self
    {
        $contents = str_replace("{{bool}}", $bool, $contents);

        dump($contents);

        return $this;
    }

    protected function replaceModelName(string &$contents, string $modelName): self
    {
        $contents = str_replace("{{modelName}}", $modelName, $contents);

        return $this;
    }

    protected function replaceRequestName(string &$contents, string $requestName): self
    {
        $contents = str_replace("{{requestName}}", $requestName, $contents);

        return $this;
    }

    protected function replaceViewPathName(string &$contents, string $viewPathName): self
    {
        $contents = str_replace("{{viewPathName}}", $viewPathName, $contents);

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
