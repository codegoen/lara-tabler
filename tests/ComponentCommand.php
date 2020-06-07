<?php

namespace Rizkhal\Tabler\Tests; 

class ComponentCommand extends TestCase
{
    public function test_true_is_true()
    {
        $this->assertTrue(true);
    }

    public function test_create_component()
    {
        $this->artisan('tabler:components');
        $this->assertStringContainsStringIgnoringCase('All components successfully created.', 'All components successfully created.');
    }
}
