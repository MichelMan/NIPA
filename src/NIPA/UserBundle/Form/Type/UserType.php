<?php

namespace NIPA\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
//use Symfony\Component\Form\FormBuilder; // old schema
use Symfony\Component\Form\FormBuilderInterface; 
use NIPA\UserBundle\Form\Type\DeskPictureType;

class UserType extends AbstractType
{
    //public function buildForm(FormBuilder $builder, array $options) // old schema
    public function buildForm(FormBuilderInterface $builder, array $options)
	{
        $builder
            ->add('Identifiant', 'text', array('max_length' => 7, 'required' => true, 'attr' => array('placeholder' => 'uXXXXXX')))
            ->add('Prenom', 'text', array('max_length' => 25, 'required' => true, 'label' => ''))
            ->add('Nom', 'text', array('max_length' => 25, 'required' => true, 'label' => ''))
            ->add('Email', 'email', array ('required' => true))
            ->add('Password', 'repeated', array(
                'type' => 'password',
                'invalid_message' => 'Les mots de passe entres ne correspondent pas',
                'required' => true,
                'first_name' => 'Password1:',
                'second_name' => 'Password2:',
            ))
            ->add('Admin', 'checkbox', array("label" => "Administrateur", "required" => false, "value" => "1"));
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'NIPA\UserBundle\Entity\Utilisateur',
        );
    }

    public function getName()
    {
        return 'Utilisateur';
    }
}