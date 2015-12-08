<?php

namespace NIPA\UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface; 
use Symfony\Component\Form\AbstractType;

class PermissionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Ajoutez vos champs ici:
        $builder->add('CMSPortefeuille');
        $builder->add('LPortefeuille');
        $builder->add('CMSDemande');
        $builder->add('LDemande');
        $builder->add('CMSProjet');
        $builder->add('LProjet');
        
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'NIPA\UserBundle\Entity\Permission',
        );
    }
    
    public function getName()
    {
        return 'nipa_user_permission_groupe';
    }
}
