<?php

namespace NIPA\ProjetBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class ProjetFormType extends AbstractType
{
   
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Ajoutez vos champs ici:
        $builder->add('referenceProjet', 'hidden');        
        $builder->add('titre');
        $builder->add('titreLot', 'text', array('required' => false));
        $builder->add('enveloppe');
        $builder->add('priorite', 'text', array('required' => false));
        $builder->add('direction');
        $builder->add('entiteMetier');
        $builder->add('offres');
        $builder->add('typeProjet');
        $builder->add('divers', 'text', array('required' => false));
        $builder->add('interlocuteurMOA', 'text', array('required' => false));
        $builder->add('porteurMetier', 'text', array('required' => false));
        $builder->add('SDM', 'text', array('required' => false));
        $builder->add('devSI');
        $builder->add('devRZO');
        $builder->add('indicateur', 'text', array('required' => false));
        $builder->add('phaseProjet', 'text', array('required' => false));
        $builder->add('annuler');
        $builder->add('suspendre');
        
        $builder->add('commentaires', 'textarea', array('required' => false, 'attr' => array('cols' => '40', 'rows' => '4')));
        $builder->add('alerte', 'textarea', array('required' => false, 'attr' => array('cols' => '30', 'rows' => '4')));

        $builder->add('escalade', 'choice', array(
            'choices'   => array(false => 'Non', true => 'Oui'),
            // *this line is important*
            'multiple'  => false,
        ));
        
        $builder->add('lotissement', 'choice', array(
            'choices'   => array(false => 'Non', true => 'Oui'),
            // *this line is important*
            'multiple'  => false,
        ));
 
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'NIPA\ProjetBundle\Entity\Projet',
        );
    }
    
    public function getName()
    {
        return 'nipa_projet_projet';
    }
}