<?php

namespace NIPA\UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface; 
use Symfony\Component\Form\AbstractType;

class GroupeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Ajoutez vos champs ici:
        $builder->add('Nom');
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'NIPA\UserBundle\Entity\Groupe',
        );
    }
    
    public function getName()
    {
        return 'nipa_user_groupe';
    }
}