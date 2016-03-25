<?php

use Silex\WebTestCase as BaseWebTestCase;

class serverIsRunningTest extends BaseWebTestCase
{
    public function createApplication()
    {
        $app = require $this->getApplicationDir().'/app.php';

        return $app;
    }

    public function getApplicationDir()
    {
        return $_SERVER['APP_DIR'];
    }
}
