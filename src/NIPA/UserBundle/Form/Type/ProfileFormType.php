<?php

namespace NIPA\UserBundle\Form\Type;

//use Symfony\Component\Form\FormBuilder; // old schema
use Symfony\Component\Form\FormBuilderInterface; 
use FOS\UserBundle\Form\Type\ProfileFormType as BaseType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class ProfileFormType extends BaseType
{
    //public function buildForm(FormBuilder $builder, array $options) // old schema
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //parent::buildForm($builder, $options);

        // Ajoutez vos champs ici:
        $builder->add('Identifiant');
        $builder->add('Prenom');
        $builder->add('Nom');
        $builder->add('email', 'email', array('label' => 'form.email', 'translation_domain' => 'FOSUserBundle'));
	$builder->add('Admin');

    }

    public function getName()
    {
        return 'nipa_user_profile';
    }
}