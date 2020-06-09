<?php

declare(strict_types=1);

namespace Rizkhal\Tabler\Console\Commands;

use Illuminate\Console\Command;
use Rizkhal\Tabler\Console\Commands\Presents\TablerAuth;

class TablerControllerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tabler:controller';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Controller';
}
