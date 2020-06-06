<?php

declare(strict_types=1);

namespace Rizkhal\Tabler\Console\Commands;

use Illuminate\Console\Command;
use Rizkhal\Tabler\Console\Commands\Traits\SupportCommands;

class TablerAuthCommand extends Command
{
    use SupportCommands;

    protected $signature = 'tabler:make-auth';

    protected $description = 'Make Authentication view scaffolding using tabler';

    protected $views = [
        'views/auth/passwords/email.stub' => 'auth/passwords/email.blade.php',
        'views/home.stub' => 'home.blade.php',
        'views/auth/passwords/reset.stub' => 'auth/passwords/reset.blade.php',
        'views/auth/register.stub' => 'auth/register.blade.php',
        'views/auth/login.stub' => 'auth/login.blade.php',
        'views/components/header.stub' => 'components/header.blade.php',
        'views/components/aside.stub' => 'components/aside.blade.php',
        'views/components/footer.stub' => 'components/footer.blade.php',
        'views/layouts/app.stub' => 'layouts/app.blade.php',
        'views/layouts/auth.stub' => 'layouts/auth.blade.php',
    ];

    /**
     * Create a new controller creator command instance.
     *
     * @return void
     */
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
        if (! is_dir(app_path('Http/Controllers/Auth'))) {
            if ($this->confirm('Auth directory doesnt exists, do you want to copy it ?')) {
                $this->call('ui:controllers');
            }
        }

        if (! is_dir('views/layouts') && ! is_dir('views/components')) {
            foreach ($this->views as $i => $view) {
                $this->createViewsDirectory($view);
                $this->putContents(resource_path("views/{$view}"), $this->getStub($i));
            }
        }

        $this->putContents(base_path('package.json'), $this->getStub('package.stub'));
        $this->putContents(base_path('webpack.mix.js'), $this->getStub('webpack.mix.stub'));

        $this->move(__DIR__.'/../../../resources/assets', resource_path('assets'));

        $this->info('Authentication scaffolding view using tabler generated successfully');
    }
}
