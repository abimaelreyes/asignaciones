<?php

namespace LEOLEX\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('LEOLEXUserBundle:User')->findAll();
        /*
        $res = 'Lista de usuario: <br />';
         foreach ($users as $user) {
         	$res .= 'Usuario: '. $user->getUsername() . ' - Email: ' . $user->getEmail() . '<br />';
         }

         return new Response($res);
         */
        
        return $this->render('LEOLEXUserBundle:user:index.html.twig', array('users' => $users));
    }

    public function viewAction($id)
    {
    	$repository = $this->getDoctrine()->getRepository('LEOLEXUserBundle:User');

    	$user = $repository->find($id);
    	//$user = $repository->findOneById($id); // otro metodo
    	//$user = $repository->findOneByUsername($nombre); // otro metodo

    	return new Response('Usuario: ' . $user->getUsername() . ' con email: ' . $user->getEmail());
    }

}
