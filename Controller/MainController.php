<?php

namespace Dellaert\ACCOBooklistBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
	public function indexAction() {
		return $this->render('DellaertACCOBooklistBundle:Main:index.html.twig');
	}
}
