<?php

namespace Controllers;

use Models\Stasich\SupBot;

class WebhookController
{
    public function indexAction()
    {
        $json = file_get_contents("php://input");
        $supBot = new SupBot();
        $supBot->addWebhookDataToDB($json);
    }
}