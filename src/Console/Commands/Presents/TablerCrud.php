<?php

declare(strict_types=1);

namespace Rizkhal\Tabler\Console\Commands\Presents;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use Rizkhal\Tabler\Console\Commands\Presents\Build;

class TablerCrud extends Build
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

        $this->buildModel()->buildController();
    }

    protected function buildModel(): self
    {
        foreach (array_keys($this->stubs) as $i => $type) {
            if ($type == "model") {
                $stub = $this->getStubs($type);
                $this->replaceNamespace($stub, $type)
                     ->replaceClass($stub, $this->stubs[$type])
                     ->replaceSoftDelete($stub, $this->stubs[$type]);
            }
        }

        return $this;
    }

    protected function buildController(): self
    {
        foreach (array_keys($this->stubs) as $i => $type) {
            if ($type == "controller") {
                $stub = $this->getStubs($type);
                $this->replaceNamespace($stub, $type)
                     ->replaceClass($stub, $this->stubs[$type])
                     ->replaceModelName($stub, $this->stubs["model"]);
            }
        }
        
        return $this;
    }
}
