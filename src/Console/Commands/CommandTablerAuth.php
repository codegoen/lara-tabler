<?php

declare(strict_types=1);

namespace Rizkhal\Tabler\Console\Commands;

use Artisan;
use Illuminate\Support\Arr;
use Illuminate\Container\Container;
use Illuminate\Filesystem\Filesystem;
use Laravel\Ui\Presets\Preset;
use Illuminate\Support\Str;
use Symfony\Component\Finder\SplFileInfo;

class CommandTablerAuth extends Preset
{
    /**
     * Init dependencies
     * 
     * @param  boolean $withAuth
     * @return void
     */
    public static function install($withAuth = false): void
    {
        static::updatePackages();
        static::updateStyles();
        static::updateBootstrapping();
        static::updateWelcomePage();
        static::scaffoldController();
        static::scaffoldAuth();
        static::removeNodeModules();
    }

    /**
     * Update package
     * 
     * @param  array  $packages
     * @return array
     */
    protected static function updatePackageArray(array $packages): array
    {
        $packagesToAdd = [
            'jquery' => '^3.5.0',
            'popper.js' => '^1.16.1',
            'tabler' => '^1.0.0-alpha.7'
        ];

        $packagesToRemove = [
            'axios',
            'lodash'
        ];

        return array_merge(
            $packagesToAdd,
            Arr::except($packages, $packagesToRemove)
        );
    }

    /**
     * Delete existsing assets in public path,
     * resource path and copy stubs to public
     * 
     * @return void
     */
    protected static function updateStyles(): void
    {
        tap(new Filesystem, function ($filesystem) {
            $filesystem->deleteDirectory(resource_path('sass'));
            $filesystem->delete(public_path('js/app.js'));
            $filesystem->delete(public_path('css/app.css'));

            // if sass directory not exists, make it..
            // if (! $filesystem->isDirectory($directory = resource_path('sass'))) {
            //     $filesystem->makeDirectory($directory, 0755, true);
            // }

            $filesystem->copyDirectory(__DIR__.'/../../stubs/resources/sass', resource_path('sass'));
        });
    }

    /**
     * Re-bootstraping assets
     * 
     * @return void
     */
    protected static function updateBootstrapping(): void
    {
        if (file_exists(resource_path('assets/js/bootstrap.js'))) {
            (new Filesystem)->delete(
                resource_path('assets/js/bootstrap.js')
            );
        }

        if (! is_dir(resource_path('js'))) {
            mkdir(resource_path('js'), 0777, true);
        }

        file_put_contents(resource_path('js/bootstrap.js'),
            (new Filesystem)->get(__DIR__.'/../../stubs/resources/js/bootstrap.js')
        );
    }

    /**
     * Update welcome page
     * 
     * @return void
     */
    protected static function updateWelcomePage(): void
    {
        (new Filesystem)->delete(
            resource_path('views/welcome.blade.php')
        );

        copy(__DIR__.'/../../stubs/resources/views/welcome.blade.php', resource_path('views/welcome.blade.php'));
    }

    /**
     * Scafollding controller
     * 
     * @return void
     */
    protected static function scaffoldController(): void
    {
        if (! is_dir($directory = app_path('Http/Controllers/Auth'))) {
            mkdir($directory, 0755, true);
        }

        $filesystem = new Filesystem;

        collect($filesystem->allFiles(base_path('vendor/laravel/ui/stubs/Auth')))
            ->each(function (SplFileInfo $file) use ($filesystem) {
                $filesystem->copy(
                    $file->getPathname(),
                    app_path('Http/Controllers/Auth/'.Str::replaceLast('.stub', '.php', $file->getFilename()))
                );
            });
    }

    /**
     * Scafollding authentication
     * 
     * @return void
     */
    protected static function scaffoldAuth(): void
    {
        file_put_contents(app_path('Http/Controllers/HomeController.php'), static::compileControllerStub());

        file_put_contents(
            base_path('routes/web.php'),
            "Auth::routes();\n\nRoute::get('/home', 'HomeController@index')->name('home');\n\n",
            FILE_APPEND
        );

        tap(new Filesystem, function ($filesystem) {
            $filesystem->copyDirectory(__DIR__.'/../../stubs/resources/views', resource_path('views'));

            collect($filesystem->allFiles(base_path('vendor/laravel/ui/stubs/migrations')))
                ->each(function (SplFileInfo $file) use ($filesystem) {
                    $filesystem->copy(
                        $file->getPathname(),
                        database_path('migrations/'.$file->getFilename())
                    );
                });
        });
    }

    /**
     * Compile HomeController
     * 
     * @return string
     */
    protected static function compileControllerStub(): string
    {
        return str_replace(
            '{{namespace}}',
            Container::getInstance()->getNamespace(),
            file_get_contents(__DIR__.'/../../stubs/Controllers/HomeController.stub')
        );
    }
}
