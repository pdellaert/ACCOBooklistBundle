<?php

namespace Dellaert\ACCOBooklistBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('DellaertACCOBooklistBundle:Default:index.html.twig', array('name' => $name));
    }
}
