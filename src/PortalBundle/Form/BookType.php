<?php

namespace PortalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class BookType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('coverImage', FileType::class, array(
                'label' => 'Cover Image (jpg file)',
                'required' => false
            ))
            ->add('imageName')
            ->add('publishDate', DateType::class, array(
                'label' => 'Date',
                'widget' => 'single_text',
                'attr'=> ['class'=>'datepicker'],
                'required' => false
            ))
            ->add('author', EntityType::class, array(
                'class' => 'PortalBundle:Author',
                'choice_label' => 'name'
            ))          
            ->add('translator', EntityType::class, array(
                'class' => 'PortalBundle:Translator',
                'choice_label' => 'name'
            ))
            ->add('publisher', EntityType::class, array(
                'class' => 'PortalBundle:Publisher',
                'choice_label' => 'name'
            ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PortalBundle\Entity\Book'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'portalbundle_book';
    }


}
