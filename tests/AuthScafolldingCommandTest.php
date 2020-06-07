<?php

namespace Rizkhal\Tabler\Tests; 

class AuthScafolldingCommandTest extends TestCase
{
    public function testAuthScaffoldingCommand()
    {
        $this->artisan('tabler:auth')->assertExitCode(0);
    }
}
