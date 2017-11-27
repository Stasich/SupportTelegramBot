<?php

namespace Controllers;

use Models\Stasich\SupBot;

class MainController
{
    public function indexAction()
    {
        $SupBot = new SupBot();
    }
}