<?php

namespace UsersBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder  ->add('email', EmailType::class, array('label' => 'Email'))
            ->add('username', null, array('label' => 'Pseudo'))
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'options' => array(
                    'translation_domain' => 'FOSUserBundle',
                    'attr' => array(
                        'autocomplete' => 'new-password',
                    ),
                ),
                'first_options' => array('label' => 'Mots de passe'),
                'second_options' => array('label' => 'Répéter mots de passe'),
                'invalid_message' => 'Les deux mots de passe ne sont identiques',
            ))
            ->add('roles', ChoiceType::class, array('choices' =>
                array(
                    'Administrateur Web' => 'ROLE_ADMIN',
                    'Commercial' => 'ROLE_COMMERCIAL',
                    'Vente' => 'ROLE_VENTE',
                ),
                'required'  => true,
                'mapped' => true,
                'multiple'=> true
            ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'UsersBundle\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'usersbundle_user';
    }


}
