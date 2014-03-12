<?php

namespace Acme\UserBundle\Controller;

use Acme\UserBundle\Form\Type\SeuilType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

use Acme\UserBundle\Form\Type\CompteType;
use Acme\UserBundle\Entity\Seuil;


class SeuilController extends Controller
{
    public function creerAction(Request $request, $id){
        $user = $this->container->get('security.context')->getToken()->getUser();

        $repository = $this->getDoctrine()
            ->getRepository('UserBundle:Compte');
        $compte = $repository->findOneById($id);

        $seuil = new Seuil();
        $form = $this->createForm(new SeuilType(), $seuil);

        if ($request->isMethod('POST')) {
            $form->bind($request);
            //if ($form->isValid()) {
            // fait quelque chose comme sauvegarder la tâche dans la bdd
            $em = $this->getDoctrine()->getManager();
            $reg = $form->getData();


            $reg->setCompteId($compte);

            $em->persist($reg);
            $em->flush();
            return $this->redirect($this->generateUrl('detailCompte', array( 'id'=>$id)));
            //}
        }

        return $this->render('UserBundle:Seuil:creer.html.twig', array(
            'form' => $form->createView(),
        ));
    }


    public function modifAction($id){
        $seuil = $this->getDoctrine()
            ->getRepository('UserBundle:Seuil')
            ->find($id);



        if (!$seuil)
        {
            throw $this->createNotFoundException(
                'Aucun produit trouvé pour cet id : '.$id
            );
        }



        $form = $this->createForm(new SeuilType(), $seuil);



        $request = $this->get('request');
        if ($request->getMethod() == 'POST')
        {
            $form->bind($request);

            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($seuil);
                $em->flush();

                return $this->redirect($this->generateUrl('detailCompte', array( 'id'=>$id)));
            }


        }

        return $this->render('UserBundle:Seuil:creer.html.twig', array(
            'form' => $form->createView(),
        ));
    }

}

