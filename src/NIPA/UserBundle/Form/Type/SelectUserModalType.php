<?php

namespace NIPA\UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface; 
use Symfony\Component\Form\AbstractType;

class SelectUserModalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('identifiant', 'entity', array(
        'class' => 'NIPAUserBundle:Utilisateur',
        'property' => 'identifiant',
        'expanded' => true,
        'multiple' => true,
        ));
        
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'NIPA\UserBundle\Entity\Utilisateur',
        );
    }
    
    public function getName()
    {
        return 'nipa_user_selectUser';
    }
}