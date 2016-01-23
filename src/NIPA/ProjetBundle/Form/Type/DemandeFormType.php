<?php

namespace NIPA\ProjetBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class DemandeFormType extends AbstractType
{
   
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Ajoutez vos champs ici:
        $builder->add('referenceDemande', 'hidden');        
        $builder->add('nom');
        /*$builder->add('priorite', 'choice', array(
            'choices'  => array(
                'Maybe' => null,
                'Yes' => true,
                'No' => false,
                ),
            // *this line is important*
            'multiple'  => false,
        ));*/
        $builder->add('description', 'textarea', array('required' => false));
        $builder->add('dateMEP', 'text', array('required' => false));        
        $builder->add('TTDSouhaite', 'text', array('required' => false));        
        $builder->add('TTDSouhaiteRevise', 'text', array('required' => false));        
        $builder->add('TTDProjets', 'text', array('required' => false));        
        $builder->add('TTDProjetsRevises', 'text', array('required' => false));        
        $builder->add('nbLots', 'text', array('required' => false));        
        $builder->add('dateCloture', 'text', array('required' => false));        
        $builder->add('REX');        
        
        /***Select modal portefeuille***/
        $builder->add('portefeuille', 'entity',
                array ('label' => 'Portefeuille',
                       'class' => 'NIPAProjetBundle:Portefeuille',
                       'property' => 'referencePortefeuille',
                       'expanded' => true,
                       'multiple' => true)
        ); 
        /*******************************/
        
        $builder->add('priorite', 'entity',
                array ('label' => 'Priorité',
                       'class' => 'NIPAProjetBundle:DemandePriorite',
                       'property' => 'nom')
        );        
        $builder->add('direction', 'entity',
                array ('label' => 'Direction',
                       'class' => 'NIPAProjetBundle:DemandeDirection',
                       'property' => 'nom')
        );
        $builder->add('entiteMetier', 'entity',
                array ('label' => 'Entité Métier',
                       'class' => 'NIPAProjetBundle:DemandeEntiteMetier',
                       'property' => 'nom')
        );
        $builder->add('offres', 'entity',
                array ('label' => 'Offre concernée',
                       'class' => 'NIPAProjetBundle:DemandeOffres',
                       'property' => 'nom')
        );
        $builder->add('typeProjet', 'entity',
                array ('label' => 'Type de projet',
                       'class' => 'NIPAProjetBundle:DemandeTypeProjet',
                       'property' => 'nom')
        );
        $builder->add('divers', 'entity',
                array ('label' => 'Divers',
                       'class' => 'NIPAProjetBundle:DemandeDivers',
                       'property' => 'valeur',
                        'required' => false)
        );
        $builder->add('demandeStatut', 'entity',
                array ('label' => 'Statut Demande',
                       'class' => 'NIPAProjetBundle:DemandeStatut',
                       'property' => 'nom')
        );
        $builder->add('porteurMetier', 'entity',
                array ('label' => 'Porteur Métier',
                       'class' => 'NIPAProjetBundle:DemandePorteurMetier',
                       'property' => 'nom')
        );
        $builder->add('interlocuteurMOA', 'entity',
                array ('label' => 'Interlocuteurs MOA',
                       'class' => 'NIPAProjetBundle:DemandeInterlocuteurMOA',
                       'property' => 'nom')
        );        
        $builder->add('SDM', 'entity',
                array ('label' => 'SDM - Pilote technique (SI/Réseau)',
                       'class' => 'NIPAProjetBundle:DemandeSDM',
                       'property' => 'nom')
        );            
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'NIPA\ProjetBundle\Entity\Demande',
        );
    }
    
    public function getName()
    {
        return 'nipa_projet_demande';
    }
}