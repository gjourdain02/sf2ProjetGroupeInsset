<?php

namespace Acme\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CompteType extends AbstractType{

    /**
     * Creation du formulaire premettant a un utilisateur de déclarer un compte bancaire ou de le modifier.
     * Composé du nom du compte bancaire et du numéro du compte. Les autres éléments, tel que
     * l'utilisateur créant le compte sont récupérer dans le controleur
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', 'text')
            ->add('numeroCompte', 'text');


    }

    /**
     * Cette fonction permets, lors de la modification d'un compte bancaire de récupérer
     * et de mettre en place sur le formulaire les informations
     * de ce même compte
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Acme\UserBundle\Entity\Compte'
        ));
    }



    public function getName()
    {
        return 'acme_userbundle_comptetype';
    }
}