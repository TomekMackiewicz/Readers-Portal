<?php

namespace PortalBundle\Form;

use PortalBundle\Form\DataTransformer\TextToAuthorTransformer;
use PortalBundle\Form\DataTransformer\TextToPublisherTransformer;
use PortalBundle\Form\DataTransformer\TextToTranslatorTransformer;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class BookType extends AbstractType
{

    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

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
                'label' => 'Publish Year',
                'widget' => 'single_text',
                'attr'=> ['class'=>'datepicker'],
                'required' => true
            ))
            ->add('addDate', DateType::class, array(
                'label' => 'Add Date',
                'widget' => 'single_text',
                'attr'=> ['class'=>'datepicker'],
                'required' => true
            )) 
            ->add('author', TextType::class, array(
                'attr'=>array('class'=>'formSearchAuthor')
            ))             
            ->add('translator', TextType::class, array(
                'attr'=>array('class'=>'searchTranslator')
            ))            
            ->add('publisher', TextType::class, array(
                'attr'=>array('class'=>'searchPublisher')
            ))                
            ->add('isbn');

        $builder->get('author')
            ->addModelTransformer(new TextToAuthorTransformer($this->manager)); 
        $builder->get('publisher')
            ->addModelTransformer(new TextToPublisherTransformer($this->manager)); 
        $builder->get('translator')
            ->addModelTransformer(new TextToTranslatorTransformer($this->manager));               
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
