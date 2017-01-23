<?php
namespace LEOLEX\UserBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use LEOLEX\UserBundle\Entity\User;
use LEOLEX\UserBundle\Form\UserType;
class UserController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $users = $em->getRepository('LEOLEXUserBundle:User')->findAll();
        
        /*
        
        $res = 'Lista de usuarios: <br />';
        
        foreach($users as $user)
        {
            $res .= 'Usuario: ' . $user->getUsername() . ' - Email: ' . $user->getEmail() . '<br />';
        }
        
        return new Response($res);
        */
        
        return $this->render('LEOLEXUserBundle:User:index.html.twig', array('users' => $users));
    }
    
    public function addAction()
    {
        $user = new User();
        $form = $this->createCreateForm($user);
        
        return $this->render('LEOLEXUserBundle:User:add.html.twig', array('form' => $form->createView()));
    }
    
    private function createCreateForm(User $entity)
    {
        $form = $this->createForm(new UserType(), $entity, array(
                'action' => $this->generateUrl('leolex_user_create'),
                'method' => 'POST'
            ));
        
        return $form;
    }
    
    public function createAction(Request $request)
    {   
        $user = new User();
        $form = $this->createCreateForm($user);
        $form->handleRequest($request);
        
        if($form->isValid())
        {
            $password = $form->get('password')->getData();
            
            $encoder = $this->container->get('security.password_encoder');
            $encoded = $encoder->encodePassword($user, $password);
            
            $user->setPassword($encoded);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            
            return $this->redirectToRoute('leolex_user_index');
        }
        
        return $this->render('LEOLEXUserBundle:User:add.html.twig', array('form' => $form->createView()));
    }
    
    public function viewAction($id)
    {
        $repository = $this->getDoctrine()->getRepository('LEOLEXUserBundle:User');
        
        $user = $repository->find($id);
        
        // $user = $repository->findOneByUsername($nombre);
        
        return new Response('Usuario: ' . $user->getUsername() . ' con email: ' . $user->getEmail());    
        
    }
}