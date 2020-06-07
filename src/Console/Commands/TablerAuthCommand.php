<?php

declare(strict_types=1);

namespace Rizkhal\Tabler\Console\Commands;

use Illuminate\Console\Command;
use Rizkhal\Tabler\Console\Commands\Presents\Tabler;

class TablerAuthCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tabler:auth
                    {--force : Overwrite existing views by default}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scaffold basic login and registration views and routes using tabler premium template';

    /**
     * Execute the console command.
     *
     * @return void
     *
     * @throws bool|void
     */
    public function handle()
    {
        /** make directory if not exists */
        static::ensureDirectoriesExist();

        /** install */
        if (is_dir(app_path('Http/Controllers/Auth')) && !$this->option('force')) {
            if (! $this->confirm('The Auth directory already exists. Do you want to replace it ?')) {
                $this->comment('Tabler scaffolding canceled');
                return false;
            }
        }

        Tabler::install();

        $this->info('Tabler scaffolding installed successfully.');
        $this->comment('Please run "npm install && npm run dev" to compile your fresh scaffolding.');
    }

    /**
     * Create the directories for the files.
     *
     * @return void
     */
    protected static function ensureDirectoriesExist(): void
    {
        if (! is_dir($directory = self::getViewPath('layouts'))) {
            mkdir($directory, 0755, true);
        }

        if (! is_dir($directory = self::getViewPath('auth/passwords'))) {
            mkdir($directory, 0755, true);
        }
    }

    /**
     * Get full view path relative to the application's configured view path.
     *
     * @param  string  $path
     * @return string
     */
    protected static function getViewPath($path): string
    {
        return implode(DIRECTORY_SEPARATOR, [
            config('view.paths')[0] ?? resource_path('views'), $path,
        ]);
    }
}
