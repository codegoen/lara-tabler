<?php

namespace Rizkhal\Tabler\Tests; 

class AuthCommandTest extends TestCase
{
    public function testExample()
    {
        $this->assertTrue(true);
    }
    
    public function testForceMakeAuth()
    {
        $this->artisan('tabler:make-auth --force')
             ->expectsQuestion('This will overwrite authentication scaffolding', 'yes')
             ->expectsQuestion('Auth directory doesnt exists, do you want to copy it ?', 'yes')
             ->assertExitCode(0);
    }
}
