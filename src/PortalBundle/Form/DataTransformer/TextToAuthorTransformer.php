<?php

namespace PortalBundle\Form\DataTransformer;

use PortalBundle\Entity\Author;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class TextToAuthorTransformer implements DataTransformerInterface
{
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Transforms an object to a string.
     *
     * @param  Author|null $author
     * @return string
     */
    public function transform($author)
    {
        if (null === $author) {
            return '';
        }

        return $author->getId();
    }

    /**
     * Transforms a string to an object.
     *
     * @param  string $authorName
     * @return Author|null
     * @throws TransformationFailedException if object (author) is not found.
     */
    public function reverseTransform($authorName)
    {
        // no text? It's optional, so that's ok
        if (!$authorName) {
            return;
        }

        $author = $this->manager
            ->getRepository('PortalBundle:Author')
            // query for the author
            ->findOneByName($authorName)
        ;

        if (null === $author) {
            $author = new Author();
            $author->setName($authorName);
            $em = $this->manager;
            $em->persist($author);
            $em->flush();            
        }

        return $author;
    }
}