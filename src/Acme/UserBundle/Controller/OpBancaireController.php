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
    public function creerAction(Request $request, $id)
    {
        $user = $this->container->get('security.context')->getToken()->getUser();

        $repository = $this->getDoctrine()
            ->getRepository('UserBundle:Compte');
        $compte = $repository->findOneById($id);

        $OpBancaire = new OperationBancaire();
        $opPeriodique = new OperationPeriodique();
        //$opPeriodique->setId(0);


        $form = $this->createForm(new OpBancaireType(), $OpBancaire);
        $form->add('save', 'submit');

        if ($request->isMethod('POST')) {
            $form->bind($request);
            //if ($form->isValid()) {
                // fait quelque chose comme sauvegarder la tâche dans la bdd
                $em = $this->getDoctrine()->getManager();
                $reg = $form->getData();
                $reg->setDateOperation(new \DateTime());
                $reg->setType(1);
                $reg->setCompte($compte);
                $reg->setVerif(1);


                $em->persist($reg);
                $em->flush();
                return $this->redirect($this->generateUrl('index'));
            //}
        }

        return $this->render('UserBundle:OpBancaire:creer.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function supprAction($id)
    {
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

        return $this->redirect($this->generateUrl('task_success'));
    }
}
