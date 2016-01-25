<?php

namespace NIPA\ProjetBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface; 
use Symfony\Component\Form\AbstractType;

class SelectPortefeuilleModalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /***Select modal portefeuille***/
        $builder->add('portefeuille', 'entity',
                array ('label' => 'Portefeuille',
                       'class' => 'NIPAProjetBundle:Portefeuille',
                       'property' => 'referencePortefeuille',
                       'expanded' => true,
                       'multiple' => true)
        ); 
        /*******************************/  
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'NIPA\ProjetBundle\Entity\Portefeuille',
        );
    }
    
    public function getName()
    {
        return 'nipa_projet_selectPortefeuille';
    }
}