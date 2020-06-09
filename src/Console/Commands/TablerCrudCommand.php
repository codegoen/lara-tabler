<?php

declare(strict_types=1);

namespace Rizkhal\Tabler\Console\Commands;

use Illuminate\Console\Command;
use Rizkhal\Tabler\Console\Commands\Presents\TablerAuth;

class TablerCrudCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tabler:install-crud';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install crud generator';

    /**
     * Execute the console command.
     *
     * @return void
     *
     * @throws bool|void
     */
    public function handle()
    {
        //
    }
}
