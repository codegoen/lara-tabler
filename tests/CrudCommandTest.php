<?php

namespace Rizkhal\Tabler\Tests; 

class CrudCommandTest extends TestCase
{
    public function testExample()
    {
        $this->assertTrue(true);
    }
    
    public function testCrudCommand()
    {
        $this->artisan('tabler:make-crud Foo --force')
             ->assertExitCode(0);

        $this->assertContains('Successfully make your tabler crud scafolding', ['Success']);
    }
}
