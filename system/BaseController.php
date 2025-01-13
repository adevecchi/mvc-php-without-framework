<?php

namespace System;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class BaseController
{
	protected $appName = '/devlab';

    protected $twig;

    public function __construct()
    {
        $this->twig = new Environment(new FilesystemLoader(__DIR__ . '/../application/Views'));
    }
}
