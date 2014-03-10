<?php

namespace Acme\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OpBancaireType extends AbstractType{

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