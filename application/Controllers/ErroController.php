<?php

namespace Application\Controllers;

use System\BaseController;

class ErroController extends BaseController
{
	public function notfound(string $message='') : void
	{
		echo $this->twig->render('erro/404.html.twig', ['message'=>$message, 'appName' => $this->appName]);
	}
}
