<?php

namespace Rizkhal\Tabler\Tests; 

class AuthScafolldingCommandTest extends TestCase
{    
    public function testAuthScaffoldingCommand()
    {
        $this->artisan('ui tabler')->assertExitCode(0);
    }
}
