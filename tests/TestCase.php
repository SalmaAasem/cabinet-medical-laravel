<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // هاد السطر كيخلي Vite ما يبقاش يصدعنا في التيست
        $this->withoutVite();
    }
}
