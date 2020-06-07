<?php

namespace Rizkhal\Tabler\Tests;

class AuthScafolldingCommandTest extends TestCase
{
    public function test_true_is_true()
    {
        $this->assertTrue(true);
    }

    public function test_tabler_auth()
    {
        $this->artisan('tabler:auth')
             ->expectsQuestion('The Auth directory already exists. Do you want to replace it ?', 'yes')
             ->assertExitCode(0);
    }
}
