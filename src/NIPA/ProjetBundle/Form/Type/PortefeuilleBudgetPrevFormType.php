<?php

namespace NIPA\ProjetBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PortefeuilleBudgetPrevFormType extends AbstractType
{
   
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Ajoutez vos champs ici:        
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'NIPA\ProjetBundle\Entity\PortefeuilleEnveloppePrev',
        );
    }
    
    public function getName()
    {
        return 'nipa_projet_portefeuille_enveloppe_prev';
    }
}