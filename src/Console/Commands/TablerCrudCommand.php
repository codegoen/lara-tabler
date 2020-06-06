<?php

declare(strict_types=1);

namespace Rizkhal\Tabler\Console\Commands;

use Illuminate\Console\Command;
use Rizkhal\Tabler\Console\Commands\Traits\SupportCommands;

class TablerCrudCommand extends Command
{
    use SupportCommands;

    protected $signature = 'tabler:make-crud {name}';

    protected $description = 'Make crud';

    protected $views = [
        'views/crud/index.stub' => 'index.blade.php',
        'views/crud/create.stub' => 'create.blade.php',
        'views/crud/edit.stub' => 'edit.blade.php',
    ];

    /**
     * Create a new controller creator command instance.
     *
     * @return void
     */
    protected $type;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle(): void
    {
        $name = $this->getArgument();

        if (! $this->classExists($this->getArgument())) {
            $this->error("File {$this->type} already exists");
        }

        $this->view($name)->model($name)->controller($name)->request($name);

        $this->info('Successfully make your tabler crud scafolding');
    }

    /**
     * Make model.
     *
     * @param  string $name
     * @return self
     */
    protected function model(string $name): self
    {
        $this->putContents(
            app_path("{$name}.php"),
            $this->replaceClass($this->getStub('app/model.stub'), $name)
        );

        return $this;
    }

    /**
     * make file crud skeleton and put it.
     *
     * @param  string $dirname
     * @return self
     */
    protected function view(string $dirname): self
    {
        // check file exists or not
        if (! $this->createViewsDirectory($dirname)) {
            // if exists give alert
            $this->error('Directory '.strtolower($dirname).' already exists');
        } else {

            // create directory where given name from console
            $this->createViewsDirectory($dirname);

            // push views from stubs where directory given name from console
            foreach ($this->views as $i => $view) {
                $this->putContents(resource_path('views/'.strtolower($dirname)."/{$view}"), $this->getStub($i));
            }

            // check file app.blade.php exists or not
            if (! file_exists(resource_path('views/layouts/app.blade.php'))) {
                // confirm make or not
                if ($this->confirm('Layout file not found, do you want to make it ?')) {

                    // make layout directory
                    $this->createViewsDirectory('layouts');

                    // push it
                    $this->putContents(
                        resource_path('views/layouts/app.blade.php'),
                        $this->getStub('views/layouts/app.stub')
                    );
                }
            }
        }

        return $this;
    }

    /**
     * Make controller.
     *
     * @param  string $name
     * @return self
     */
    protected function controller(string $name): self
    {
        $this->putContents(
            controller_path("{$name}Controller.php"),
            $this->replaceClass($this->getStub('app/controller.stub'), $name)
        );

        return $this;
    }

    /**
     * Make request.
     *
     * @param  string $name
     * @return self
     */
    protected function request(string $name): self
    {
        $this->putContents(
            request_path("{$name}Request.php"),
            $this->replaceClass($this->getStub('app/request.stub'), $name)
        );

        return $this;
    }

    /**
     * Replace class in stub file.
     *
     * @param  string $stub
     * @param  string $name
     * @return string
     */
    protected function replaceClass(string $stub, string $name): string
    {
        $class = str_replace($this->getNamespace($name).'\\', '', $name);

        return str_replace(['{{ TablerClass }}', '{{ class }}', '{{ modelName }}'], $class, $stub);
    }

    /**
     * Get the full namespace for a given class, without the class name.
     *
     * @param  string  $name
     * @return string
     */
    protected function getNamespace(string $name): string
    {
        return trim(implode('\\', array_slice(explode('\\', $name), 0, 0)), '\\');
    }

    /**
     * Get argument from console.
     *
     * @return string
     */
    protected function getArgument(): string
    {
        return trim($this->argument('name'));
    }
}
