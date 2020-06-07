<?php

declare(strict_types=1);

namespace Rizkhal\Tabler\Console\Commands;

use Illuminate\Console\Command;

class TablerComponentCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tabler:components
                        {--component= : Component}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create components using tabler';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        if (! is_dir($directory = resource_path('views/components'))) {
            mkdir($directory, 0755, true);
        }

        $root = __DIR__.'/Presents/tabler-components-stubs/';

        if (! is_null($optionComponent = $this->option('component'))) {
            $componentInStubs = $root.$optionComponent.'.blade.php';

            if (! file_exists($componentInStubs)) {
                $this->error("Component {$optionComponent} doesnt exists.");
                exit;
            }

            if (file_exists($existsComponent = resource_path("views/components/{$optionComponent}.blade.php"))) {
                $this->error("Component {$existsComponent} already exists.");
                exit;
            }

            copy($componentInStubs, resource_path("views/components/{$optionComponent}.blade.php"));

            $this->info("Component {$optionComponent} successfully created.");
            exit;
        }

        // glob() find pathnames matching a pattern
        // returns an array containing the matched files/directories,
        // an empty array if no file matched or FALSE on error
        $components = glob("{$root}*.blade.php");

        foreach ($components as $i => $component) {
            $files = str_replace(
                        __DIR__.'/Presents/tabler-components-stubs/',
                        resource_path('views/components/'),
                        $component
                    );

            copy($component, $files);
        }

        $this->info('All components successfully created.');
    }
}
