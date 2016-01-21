<?php

namespace NIPA\ProjetBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class PortefeuilleFormType extends AbstractType
{
   
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Ajoutez vos champs ici:
        $builder->add('referencePortefeuille', 'hidden');        
        $builder->add('nom');
        $builder->add('description', 'textarea', array('required' => false));
        $builder->add('portefeuilleAnnee', 'entity',
                array ('label' => 'Année portefeuille',
                       'class' => 'NIPAProjetBundle:PortefeuilleAnnee',
                       'property' => 'valeur')
        );
        $builder->add('portefeuilleEnveloppe', 'entity',
                array ('label' => 'Enveloppe',
                       'class' => 'NIPAProjetBundle:PortefeuilleEnveloppe',
                       'property' => 'nom'
                       )
        );
        $builder->add('portefeuilleStatut', 'entity',
                array ('label' => 'Statut',
                       'class' => 'NIPAProjetBundle:PortefeuilleStatut',
                       'property' => 'nom'
                       )
        );            
        
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'NIPA\ProjetBundle\Entity\Portefeuille',
        );
    }
    
    public function getName()
    {
        return 'nipa_projet_portefeuille';
    }
}