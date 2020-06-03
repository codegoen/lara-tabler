<?php

declare(strict_types=1);

namespace Tests;

class TestCommand extends TestCase
{
    /** @tests */
    public function testsMakeAuthCommand()
    {
        $this->artisan('tabler:make-auth');

        $this->assertTrue(is_file(__DIR__.'/../src/Console/Commands/TablerAuthCommand.php'));
    }
}
