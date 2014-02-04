<?php

namespace Acme\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Acme\UserBundle\Entity\Compte;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

use Acme\UserBundle\Form\Type\CompteType;


class CompteController extends Controller
{
    public function creerAction(Request $request)
    {
        // crée une tâche et lui donne quelques données par défaut pour cet exemple
        $compte = new Compte();
        $user = $this->container->get('security.context')->getToken()->getUser();
        $compte->setUser($user);


        $form = $this->createForm(new CompteType(), $compte);

        $form->handleRequest($request);

        if ($form->isValid()) {
            // fait quelque chose comme sauvegarder la tâche dans la bdd
            $em = $this->getDoctrine()->getManager();
            $reg = $form->getData();
            $em->persist($reg);
            $em->flush();
            return $this->redirect($this->generateUrl('task_success'));
        }
        return $this->render('UserBundle:Compte:creer.html.twig', array(
            'form' => $form->createView(),
        ));
        /*return $this->render(
            'UserBundle:Default:index.html.twig',
            array('name' => $name)
        );
        /return new Response('<html><body>Hello '.$name.'!</body></html>');*/
    }

    public function modifAction($id){
        $compte = $this->getDoctrine()
            ->getRepository('UserBundle:Compte')
            ->find($id);


        if (!$compte)
        {
            throw $this->createNotFoundException(
                'Aucun produit trouvé pour cet id : '.$id
            );
        }

        $form = $this->createForm(new CompteType(), $compte);


        $request = $this->get('request');
        if ($request->getMethod() == 'POST')
        {
            $form->bind($request);

            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($compte);
                $em->flush();

                return $this->redirect($this->generateUrl('task_success'));
            }


        }

        return $this->render('UserBundle:Compte:modif.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function supprAction($id)
    {
        $compte = $this->getDoctrine()
            ->getRepository('UserBundle:Compte')
            ->find($id);

        if (!$compte)
        {
            throw $this->createNotFoundException(
                'Aucun produit trouvé pour cet id : '.$id
            );
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($compte);
        $em->flush();
    }

    public function modifAction($id){

    }
}