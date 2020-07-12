<?php
use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Creates the application.
     *
     * @return \Tasyakur\App
     */
    public function createApplication()
    {
        return require __DIR__.'../tasyakur-app.php';
    }
}