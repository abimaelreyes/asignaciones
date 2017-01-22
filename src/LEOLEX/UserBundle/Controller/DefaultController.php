<?php

namespace LEOLEX\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('LEOLEXUserBundle:Default:index.html.twig', array('name' => $name));
    }
}
