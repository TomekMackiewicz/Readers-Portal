<?php

namespace PortalBundle\Form\DataTransformer;

use PortalBundle\Entity\Translator;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class TextToTranslatorTransformer implements DataTransformerInterface
{
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Transforms an object to a string.
     *
     * @param  Translator|null $translator
     * @return string
     */
    public function transform($translator)
    {
        if (null === $translator) {
            return '';
        }

        return $translator->getId();
    }

    /**
     * Transforms a string to an object.
     *
     * @param  string $translatorName
     * @return Translator|null
     * @throws TransformationFailedException if object (translator) is not found.
     */
    public function reverseTransform($translatorName)
    {
        // no text? It's optional, so that's ok
        if (!$translatorName) {
            return;
        }

        $translator = $this->manager
            ->getRepository('PortalBundle:Translator')
            // query for the translator
            ->findOneByName($translatorName)
        ;

        if (null === $translator) {
            $translator = new Translator();
            $translator->setName($translatorName);
            $em = $this->manager;
            $em->persist($translator);
            $em->flush();
        }

        return $translator;
    }
}