<?php

declare(strict_types=1);

namespace Rizkhal\Tabler\Console\Commands;

use Illuminate\Console\Command;

class TablerAuthCommand extends Command
{
    protected $signature = "tabler:make-auth";

    protected $description = "Make auth scafolding using tabler";

    protected $auth = [
        "/stubs/make/views/auth/login.stub" => "auth/login.blade.php",
        "/stubs/make/views/auth/register.stub" => "auth/register.blade.php",
        "/stubs/make/views/auth/passwords/email.stub" => "auth/passwords/register.blade.php",
        "/stubs/make/views/auth/passwords/reset.stub" => "auth/passwords/register.blade.php",
        "/stubs/make/views/layouts/app.stub" => "layouts/app.blade.php",
        "/stubs/make/views/layouts/auth.stub" => "layouts/auth.blade.php",
    ];

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the command
     * 
     * @return void
     */
    public function handle(): void
    {
        $this->createDir();

        foreach ($this->auth as $i => $view) {            
            file_put_contents(
                resource_path("views/{$view}")
            , file_get_contents(__DIR__.$i));
        }

        $this->mix();

        $this->info('Auth scafolding view generated!');
    }

    /**
     * Put and copy file
     * 
     * @return void
     */
    protected function mix(): void
    {
      $this->put('package.json', 'package.stub');
      $this->put('webpack.mix.js', 'webpack.mix.stub');

      $this->xcopy(__DIR__.'/../../../resources/assets', resource_path('assets'));
    }

    /**
     * Put contents
     * 
     * @param  string $current
     * @param  string $target
     * @return void
     */
    protected function put(string $current, string $target): void
    {
      file_put_contents(
            base_path($current),
            file_get_contents(__DIR__."/stubs/make/{$target}")
        );
    }

    /**
     * Create directory
     * 
     * @return void
     */
    protected function createDir(): void
    {
        if (! is_dir(resource_path("views/auth"))) {
            mkdir(resource_path("views/auth"), 0775, true);
        }

        if (! is_dir(resource_path("views/auth/passwords"))) {
            mkdir(resource_path("views/auth/passwords"), 0775, true);
        }

        if (! is_dir(resource_path("views/layouts"))) {
            mkdir(resource_path("views/layouts"), 0775, true);
        }

        if (! is_dir(resource_path("views/components"))) {
            mkdir(resource_path("views/components"), 0755, true);
        }
    }

    /**
     * Copy file
     * 
     * @param  string  $source
     * @param  string  $destination
     * @param  integer $permissions
     * @return bool|void
     */
    protected function xcopy($source, $destination, $permissions = 0775): ?bool
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
