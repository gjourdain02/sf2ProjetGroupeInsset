<?php

namespace Acme\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Acme\UserBundle\Entity\Compte;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        // crée une tâche et lui donne quelques données par défaut pour cet exemple
        $compte = new Compte();
        $user = $this->container->get('security.context')->getToken()->getUser();
        $compte->setUser($user);


        $form = $this->createFormBuilder($compte)
            ->add('nom', 'text')
            ->add('numeroCompte', 'text')
            ->add('save', 'submit')
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            // fait quelque chose comme sauvegarder la tâche dans la bdd
            $em = $this->getDoctrine()->getManager();
            $reg = $form->getData();
            $em->persist($reg);
            $em->flush();
            return $this->redirect($this->generateUrl('task_success'));
        }
        return $this->render('UserBundle:Default:index.html.twig', array(
            'form' => $form->createView(),
        ));
        /*return $this->render(
            'UserBundle:Default:index.html.twig',
            array('name' => $name)
        );
        //return new Response('<html><body>Hello '.$name.'!</body></html>');*/
    }
}