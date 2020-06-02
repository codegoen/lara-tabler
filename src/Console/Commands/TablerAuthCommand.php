<?php

namespace Rizkhal\Tabler\Console\Commands;

use Illuminate\Console\Command;

class TablerAuthCommand extends Command
{
    protected $signature = "make:tabler {--auth: make tabler auth scafolding}";

    protected $description = "Auth scafolding using tabler";

    protected $auth = [
        "/stubs/make/views/auth/login.stub" => "auth/login.blade.php",
        "/stubs/make/views/auth/register.stub" => "auth/register.blade.php",
        "/stubs/make/views/components/header.stub" => "components/header.blade.php",
        "/stubs/make/views/layouts/app.stub" => "layouts/app.blade.php",
        "/stubs/make/views/layouts/auth.stub" => "layouts/auth.blade.php",
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $this->createDir();

        foreach ($this->auth as $i => $view) {            
            file_put_contents(
                resource_path("views/{$view}")
            , file_get_contents(__DIR__.$i));
        }

        $this->mix();

        $this->info('Works like magic!');
    }

    protected function mix(): void
    {
        file_put_contents(
            base_path('package.json'),
            file_get_contents(__DIR__."/stubs/make/package.stub")
        );

        file_put_contents(
            base_path('webpack.mix.js'),
            file_get_contents(__DIR__."/stubs/make/webpack.mix.stub")
        );

        $this->xcopy(__DIR__.'/../../../resources/assets', resource_path('assets'));
    }

    protected function createDir(): void
    {
        if (! is_dir(resource_path("views/auth"))) {
            mkdir(resource_path("views/auth"), 0775, true);
        }

        if (! is_dir(resource_path("views/layouts"))) {
            mkdir(resource_path("views/layouts"), 0775, true);
        }

        if (! is_dir(resource_path("views/components"))) {
            mkdir(resource_path("views/components"), 0755, true);
        }
    }

    protected function xcopy($source, $destination, $permissions = 0775)
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
       if (!is_dir($destination)) {
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
           $this->xcopy("$source/$entry", "$destination/$entry", $permissions);
       }
       // Clean up
       $dir->close();
       return true;
    }
}
