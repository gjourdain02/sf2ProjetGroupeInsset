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
    /** Crée un seuil pour le compte bancaire
     * @param Request $request
     * @param $id compte bancaire auquel on veut associer le seuil
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function creerAction(Request $request, $id){
        //verification de l'identification au compte
        $user = $this->container->get('security.context')->getToken()->getUser();
        if (!is_object($user) ){
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }

        $repository = $this->getDoctrine()
            ->getRepository('UserBundle:Compte');
        $compte = $repository->findOneById($id);

        $seuil = new Seuil();
        $form = $this->createForm(new SeuilType(), $seuil);

        if ($request->isMethod('POST')) {
            $form->bind($request);

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

    /** Permets de modifier la valeur du seuil
     * @param $id seuil a modifié
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function modifAction($id){

        //verification de l'identification au compte
        $user = $this->container->get('security.context')->getToken()->getUser();
        if (!is_object($user) ){
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }

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

                return $this->redirect($this->generateUrl('montrerCompte'));
            }


        }

        return $this->render('UserBundle:Seuil:creer.html.twig', array(
            'form' => $form->createView(),
        ));
    }

}

