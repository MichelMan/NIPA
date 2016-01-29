<?php

namespace NIPA\ProjetBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class DemandeListeInstanceFormType extends AbstractType
{
   
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Ajoutez vos champs ici:
        $builder->add('datePrev');        
        $builder->add('dateRev', 'text', array('required' => false));        
        $builder->add('validationEffective');
        $builder->add('remarques', 'textarea', array('required' => false));

        /*******************************/
        
        $builder->add('instance', 'entity',
                array ('label' => 'Instance',
                       'class' => 'NIPAProjetBundle:DemandeInstance',
                       'property' => 'nom')
        );        
        $builder->add('statut', 'entity',
                array ('label' => 'Statut',
                       'class' => 'NIPAProjetBundle:DemandeStatutInstance',
                       'property' => 'nom')
        );
      
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'NIPA\ProjetBundle\Entity\DemandeStatutInstance',
        );
    }
    
    public function getName()
    {
        return 'nipa_projet_demande_instance';
    }
}