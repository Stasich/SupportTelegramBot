<?php

namespace Controllers;

class Router
{
    public function __construct()
    {

    }

    private function getUri()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI']);
        }
    }

    public function get()
    {
        $actionName = 'index';

        $uri = $this->getUri();
        $uriArr = parse_url($uri);
        $piecesOfUrl = explode('/', $uriArr['path']);

        if (!empty($piecesOfUrl[1]))
        {
            $actionName = $piecesOfUrl[1];
        }

        $actionName = strtolower($actionName);
        return $actionName;
    }
}