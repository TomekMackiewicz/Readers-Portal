<?php

namespace PortalBundle\Form\DataTransformer;

use PortalBundle\Entity\Publisher;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class TextToPublisherTransformer implements DataTransformerInterface
{
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Transforms an object to a string.
     *
     * @param  Publisher|null $publisher
     * @return string
     */
    public function transform($publisher)
    {
        if (null === $publisher) {
            return '';
        }

        //return $publisher->getId();
        return $publisher->getName();
    }

    /**
     * Transforms a string to an object.
     *
     * @param  string $publisherName
     * @return Publisher|null
     * @throws TransformationFailedException if object (publisher) is not found.
     */
    public function reverseTransform($publisherName)
    {
        // no text? It's optional, so that's ok
        if (!$publisherName) {
            return;
        }

        $publisher = $this->manager
            ->getRepository('PortalBundle:Publisher')
            // query for the publisher
            ->findOneByName($publisherName)
        ;

        if (null === $publisher) {
            $publisher = new Publisher();
            $publisher->setName($publisherName);
            $em = $this->manager;
            $em->persist($publisher);
            $em->flush();            
        }

        return $publisher;
    }
}