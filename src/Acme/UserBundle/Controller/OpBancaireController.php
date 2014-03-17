<?php

namespace Acme\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

use Acme\UserBundle\Form\Type\OpBancaireType;
use Acme\UserBundle\Entity\Compte;
use Acme\UserBundle\Entity\OperationBancaire;
use Acme\UserBundle\Entity\OperationPeriodique;


class OpBancaireController extends Controller
{
    /**
     * Cette fonction va creer une opération bancaire pour le compte bancaire selectionné
     *
     * @param Request $request
     * @param $id id du compte bancaire
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function creerAction(Request $request, $id)
    {
        //verification de l'identification au compte
        $user = $this->container->get('security.context')->getToken()->getUser();
        if (!is_object($user) ){
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }

        $repository = $this->getDoctrine()
            ->getRepository('UserBundle:Compte');
        $compte = $repository->findOneById($id);

        $OpBancaire = new OperationBancaire();
        $opPeriodique = new OperationPeriodique();


        //appel du formulaire de creation d'opération
        $form = $this->createForm(new OpBancaireType(), $OpBancaire);
        $form->add('type', 'checkbox', array(
            'label'     => 'Crédit ?',
            'required'  => false,
        ) );
        $form->add('save', 'submit');

        if ($request->isMethod('POST')) {
            $form->bind($request);

            $em = $this->getDoctrine()->getManager();
            $reg = $form->getData();
            $reg->setDateOperation(new \DateTime());

            $reg->setCompteId($compte);
            $reg->setVerif(1);


            $em->persist($reg);
            $em->flush();
            return $this->redirect($this->generateUrl('detailCompte', array( 'id'=>$id)));

        }

        return $this->render('UserBundle:OpBancaire:creer.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function supprAction($id)
    {
        //verification de l'identification au compte
        $user = $this->container->get('security.context')->getToken()->getUser();
        if (!is_object($user) ){
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }

        $operation = $this->getDoctrine()
            ->getRepository('UserBundle:OperationBancaire')
            ->find($id);


        if (!$operation)
        {
            throw $this->createNotFoundException(
                'Aucun produit trouvé pour cet id : '.$id
            );
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($operation);
        $em->flush();

        return $this->redirect($this->generateUrl('montrerCompte'));
    }
}
