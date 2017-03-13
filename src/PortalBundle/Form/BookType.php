<?php

namespace PortalBundle\Form;

use PortalBundle\Form\DataTransformer\TextToAuthorTransformer;
use PortalBundle\Form\DataTransformer\TextToPublisherTransformer;
use PortalBundle\Form\DataTransformer\TextToTranslatorTransformer;
//use PortalBundle\Form\DataTransformer\TextToTagsTransformer;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

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
            ->add('title', TextType::class, array(
                'required' => true
            ))
            ->add('description', TextareaType::class, array(
                'required' => false
            ))   
            ->add('coverImage', FileType::class, array(
                'label' => 'Cover Image (jpg file)',
                'required' => false
            ))
            // ->add('imageName', TextType::class, array(
            //     'required' => false
            // ))
            ->add('publishDate', DateType::class, array(
                'label' => 'Publish Date',
                'widget' => 'single_text',
                'format' => 'yyyy',
                //'attr'=> array('class'=>'datepicker'),
                'required' => false
            )) 
            // ->add('addDate', DateType::class, array(
            //     'widget' => 'single_text',
            //     'attr'=> array('class'=>'datepicker'),
            //     'required' => false
            // ))                      
            ->add('author', TextType::class, array(
                'attr' => array('class'=>'formSearchAuthor'),
                'required' => true
            ))             
            ->add('translator', TextType::class, array(
                'attr' => array('class'=>'searchTranslator'),
                'required' => false
            ))            
            ->add('publisher', TextType::class, array(
                'attr' => array('class'=>'searchPublisher'),
                'required' => false
            ))                
            ->add('isbn', TextType::class, array(
                'label' => 'ISBN',                
                'required' => false
            ))
            ->add('genres', EntityType::class, array(
                'label' => 'Genres',
                'class' => 'PortalBundle:Genre',
                'choice_label' => 'name',
                'label_attr' => array('class' => 'checkbox-inline'),               
                'expanded' => true,
                'multiple' => true,
                'required' => false,
                'by_reference' => true,           
            ))
            ->add('tags','mk_tag', array(
                'label'=>'Tags',
                'required' => false,
            ));                    

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
