<?php

namespace NIPA\UserBundle\Form\Type;

//use Symfony\Component\Form\FormBuilder; // old schema
use Symfony\Component\Form\FormBuilderInterface; 
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class RegistrationFormType extends BaseType
{
    //public function buildForm(FormBuilder $builder, array $options) // old schema
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        
        // Ajoutez vos champs ici:
        $builder->add('Identifiant');
        $builder->add('Prenom');
        $builder->add('Nom');
        $builder->add('Email');
	$builder->add('Admin');

    }

    public function getName()
    {
        return 'nipa_user_registration';
    }
}