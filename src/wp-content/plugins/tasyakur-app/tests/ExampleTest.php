<?php
require_once 'TestCase.php';

final class ExampleTest extends TestCase
{
    /**
     * A basic test example
     *
     * @return void
     */
    public function testTrueAssetsToTrue()
    {
        $condition = true;
        $this->assertTrue($condition);
    }
}