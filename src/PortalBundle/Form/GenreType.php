<?php

namespace PortalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EntityType;

class GenreType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('genres', EntityType::class, array(
                'label' => 'Genres',
                'class' => 'PortalBundle:Genre',
                'choice_label' => 'name',
                'expanded' => true,
                'multiple' => true,
                'required' => false 
                // 'label' => 'Genres',
                // 'class' => 'PortalBundle:Genre',
                // 'choice_label' => 'name',
                // 'expanded' => true,
                // 'multiple' => true,
                // 'required' => false           
            ));

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PortalBundle\Entity\Genre'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'portalbundle_genre';
    }


}