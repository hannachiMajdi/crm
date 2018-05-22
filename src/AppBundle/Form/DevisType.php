<?php

namespace AppBundle\Form;

use AppBundle\Entity\Affaire;
use AppBundle\Entity\DevisProduit;
use AppBundle\Entity\Service;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DevisType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ref')
            ->add('date')
            ->add('devisProduits', CollectionType::class, array(
                'entry_type' => DevisProduitType::class,
                'entry_options' => array('label' => false),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label'=>false
            ))
            ->add('services', EntityType::class, array(
                'class' => Service::class,
                'multiple'=>true,
            ))
            ->add('affaire', EntityType::class, array(
                'class' => Affaire::class,
            ))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Devis'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_devis';
    }


}
