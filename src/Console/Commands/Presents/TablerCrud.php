<?php

declare(strict_types=1);

namespace Rizkhal\Tabler\Console\Commands\Presents;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;

class TablerCrud
{
    /**
     * Stubs filename
     * 
     * @var array
     */
    protected $stubs = [];

    /**
     * Get incoming request
     * 
     * @param  array  $requests
     * @return void
     */
    public function getRequest(array $requests): void
    {
        foreach (Arr::except($requests, '_token') as $i => $request) {
            if (! is_null($requests[$i])) {
                $this->stubs[$i] = $request;
            }
        }

        $this->buildClass();
    }

    /**
     * Build the class
     * 
     * @return void
     */
    protected function buildClass()
    {
        foreach ($this->stubs as $i => $stub) {
            $contents = $this->getStubs($i);
            $this
                ->replaceNamespace($contents, $stub)
                ->replaceClass($contents, $stub)
                ->replaceSoftDelete($contents, $stub);
        }
    }

    protected function getStubs($filename): string
    {
        return file_get_contents(__DIR__."/tabler-crud-stubs/{$filename}.stub");
    }

    /**
     * Replace the namespace
     * 
     * @param  string &$contents
     * @param  string $namespace
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
     * @return self
     */
    protected function replaceClass(string &$contents, string $class): self
    {
        $contents = str_replace("{{class}}", $class, $contents);

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

        dd($contents);

        return $this;
    }
}
