<?php

namespace BlazonCms\OAuth2;

class Module
{
    public function __invoke()
    {
        return require __DIR__.'/../config/config.php';
    }
}
