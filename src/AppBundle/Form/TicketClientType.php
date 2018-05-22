<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketClientType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('titre')->add('description',TextareaType::class)->add('date')
            ->add('type', ChoiceType::class, array('choices' =>
                array(
                    'Réclamation' => 'Reclamation',
                ),
                'required'  => true,

            ))
            ->add('etat', ChoiceType::class, array('choices' =>
                array(
                    'En attente' => 'En attente',
                    'En cours de traitement' => 'En cours de traitement',
                    'Résolu' => 'Résolu',
                ),
                'required'  => true,

            ))

        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\TicketClient'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_ticketclient';
    }


}
