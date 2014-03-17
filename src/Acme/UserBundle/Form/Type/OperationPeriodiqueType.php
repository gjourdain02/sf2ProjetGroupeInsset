<?php
/**
 * Created by PhpStorm.
 * User: guiguinox
 * Date: 17/03/14
 * Time: 16:44
 */



namespace Acme\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OperationPeriodiqueType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', 'text')
            ->add('montant', 'text')
            ->add('categories', 'entity', array(
                'class' => 'UserBundle:Categorie',
                'property' => 'nom',
                'multiple' => true,
                'expanded' => false

            ));
            /* il va falloir modifier l'opération périodique .
                l'opération périodique ne peut pas avoir de date mais un jour d'application (genre le 12 de chaque mois)


            */
           // ->add('applicationDay' , text);


    }


    /*public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Acme\UserBundle\Entity\OperationBancaire'
        ));
    }*/



    public function getName()
    {
        return 'acme_userbundle_opbancairetype';
    }
}