<?php

namespace Application\Controllers;

use System\BaseController;
use Application\Services\TempConvert;
use Application\Helpers\Json;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends BaseController
{
	private $request;
	private $response;

	public function __construct()
	{
		parent::__construct();

		$this->request = Request::createFromGlobals();
		$this->response = new Response();
	}

	public function index() : void
	{
		$view = $this->twig->render('home/index.html.twig');

		$this->response->setContent($view);
        $this->response->send();
	}

	public function converter()
	{
		$input = Json::decode($this->request->getContent());

		$result = TempConvert::get($input->grau, floatval($input->temperatura));

		$this->response->setContent($result);
        $this->response->headers->set('Content-Type', 'application/json');
        $this->response->send();
	}
}
