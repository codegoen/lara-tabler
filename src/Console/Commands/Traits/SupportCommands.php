<?php

namespace Rizkhal\Tabler\Console\Commands\Traits;

use Illuminate\Support\Str;

trait SupportCommands
{
    /**
     * Get stubs
     * 
     * @param  string $name
     * @return string
     */
    protected function getStub(string $name): string
    {
        return file_get_contents(__DIR__."/../stubs/make/$name");
    }

    /**
     * Put contents
     * 
     * @param  string $filename
     * @param  string $resources
     * @return self
     */
    protected function putContents(string $filename, string $resources): self
    {
        file_put_contents($filename, $resources);

        return $this;
    }

    /**
     * Determine if the class already exists.
     *
     * @param  string  $rawName
     * @return bool
     */
    protected function classExists($rawName): bool
    {
        $model = $this->searchClass($rawName);
        $request = $this->searchClass("Http\\Requests\\{$rawName}", 'request');
        $controller = $this->searchClass("Http\\Controllers\\{$rawName}", 'controller');

        if (file_exists($model)) {
            $this->type = $model;
            return false;
        }

        if (file_exists($request)) {
            $this->type = $request;
            return false;
        }

        if (file_exists($controller)) {
            $this->type = $controller;
            return false;
        }

        return true;
    }

    /**
     * Search replace class
     * 
     * @param  string $filename
     * @param  string $type
     * @return string
     */
    protected function searchClass(string $filename, string $type = ''): string
    {
        return $this->laravel['path'].'/'.str_replace('\\', '/', "{$filename}".ucfirst($type)).'.php';
    }

    /**
     * Create directory only in views
     * 
     * @return void
     */
    protected function createViewsDirectory(string $dirname, int $permission = 0775)
    {
        $dirname = trim(strtolower($dirname));

        $directory = resource_path("views/{$dirname}");

        if (! is_dir($directory)) {
            return mkdir($directory, $permission, true);
        }

        return false;
    }

    /**
     * Copy file.
     *
     * @param  string  $source
     * @param  string  $destination
     * @param  int $permissions
     * @return bool|void
     */
    protected function move(string $source, string $destination, int $permissions = 0775): ?bool
    {
        // Check for symlinks
        if (is_link($source)) {
            return symlink(readlink($source), $destination);
        }
        // Simple copy for a file
        if (is_file($source)) {
            return copy($source, $destination);
        }
        // Make destination directory
        if (! is_dir($destination)) {
            mkdir($destination, $permissions);
        }
        // Loop through the folder
        $dir = dir($source);
        while (false !== $entry = $dir->read()) {
            // Skip pointers
            if ($entry == '.' || $entry == '..') {
                continue;
            }
            // Deep copy directories
            $this->move("$source/$entry", "$destination/$entry", $permissions);
        }
        // Clean up
        $dir->close();

        return true;
    }
}
