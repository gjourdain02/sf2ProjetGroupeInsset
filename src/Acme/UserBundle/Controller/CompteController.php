<?php

namespace Acme\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

use Acme\UserBundle\Form\Type\CompteType;
use Acme\UserBundle\Entity\Compte;


class CompteController extends Controller
{
    /**
     * Cette fonction va afficher touts les compte pour le client qui est connecté
     * c'est la qu'il pourra accéder a la modification, suppression d'un compte
     * mais aussi la possibilité de voir plus précisement un compte en particulier en cliquant dessus.
     *
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function showAction()
    {
        $user = $this->container->get('security.context')->getToken()->getUser();


        $compte = $this->getDoctrine()
            ->getRepository('UserBundle:Compte')
            ->findByUser($user);

        $pasCompte = false;

        if (!$compte)
        {
            $pasCompte = true;
            return $this->render('UserBundle:Compte:show.html.twig', array(

                'pasCompte' => $pasCompte));
        }


        for($i=0;$i<sizeof($compte);$i++)
        {
            $soldeRes = $this->soldeCompte($compte[$i]);
            $soldeOp[$i]['solde'] = $soldeRes['solde'];
            $soldeOp[$i]['operations'] = $soldeRes['operations'];
        }

        return $this->render('UserBundle:Compte:show.html.twig', array(
            'soldeOp' => $soldeOp,
            'comptes' => $compte,
            'pasCompte' => $pasCompte));
    }

    /**
     * Ici, la fonction va calculer le solde d'un compte donné
     * Pour cela, on va recupérer les opération sur ce compte et faire le calcul.
     * On verifie le type de l'opération pour savoir si il s'agit d'un débit ou d'un crédit
     * @param Compte $compte
     * @return array
     */
    public function soldeCompte(Compte $compte)
    {
        $operations = $this->getDoctrine()
            ->getRepository('UserBundle:OperationBancaire')
            ->findByCompteId($compte);
        $solde = 0;
        foreach ($operations as $k => $v)
        {
            if ($v->getType())
            {
                $solde += $v->getMontant();
            }
            else
            {
                $solde -= $v->getMontant();
            }
        }
        return array('solde' => $solde, 'operations' => $operations);
    }

    public function detailAction($id){
        $user = $this->container->get('security.context')->getToken()->getUser();
        $compte = $this->getDoctrine()
            ->getRepository('UserBundle:Compte')
            ->find($id);

        if (!$compte)
        {
            throw $this->createNotFoundException(
                'Aucun compte trouvé pour cet id : '.$id
            );

        }
        if ($compte->getUser()->getId() != $user->getId())
        {
            /*throw $this->createNotFoundException(
                'Ceci n\'est pas votre compte !'
            );*/
            $this->get('session')->getFlashBag()->add(
                'pasSonCompte',
                'Vous ne pouvez acceder a un compte qui ne vous appartient pas'
            );
            return $this->redirect($this->generateUrl('montrerCompte'));
        }

        $ops = $this->getDoctrine()
            ->getRepository('UserBundle:OperationBancaire')
            ->findByCompteId($compte);

        $seuil = $this->getDoctrine()
            ->getRepository('UserBundle:Seuil')
            ->findOneByCompteId($compte);

        $pasSeuil = false;
        if (!$seuil){
            $pasSeuil = true;
        }

        return $this->render('UserBundle:Compte:detail.html.twig',
            array('solde' => $this->soldeCompte($compte)['solde'],
                  'operations' => $ops,
                  'passeuil' => $pasSeuil,
                  'seuil' => $seuil,
                  'compte' => $compte));

    }

    public function creerAction(Request $request)
    {
        // crée une tâche et lui donne quelques données par défaut pour cet exemple
        $compte = new Compte();
        $compte->setActif('1');
        $user = $this->container->get('security.context')->getToken()->getUser();
        $compte->setUser($user);


        $form = $this->createForm(new CompteType(), $compte);
        $form->add('save', 'submit');

        $form->handleRequest($request);

        if ($form->isValid()) {
            // fait quelque chose comme sauvegarder la tâche dans la bdd
            $em = $this->getDoctrine()->getManager();
            $reg = $form->getData();
            $em->persist($reg);
            $em->flush();
            $idCompte = $reg->getId();
            return $this->redirect($this->generateUrl('creerOperation', array('id' => $idCompte)));
        }
        return $this->render('UserBundle:Compte:creer.html.twig', array(
            'form' => $form->createView(),
        ));

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
        $form->add('actif', 'checkbox', array(
            'label'     => 'Activé ',
            'required'  => false,
        ) )
            ->add('save', 'submit');


        $request = $this->get('request');
        if ($request->getMethod() == 'POST')
        {
            $form->bind($request);

            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($compte);
                $em->flush();

                return $this->redirect($this->generateUrl('montrerCompte'));
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

        return $this->redirect($this->generateUrl('montrerCompte'));
    }

}