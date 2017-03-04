<?php

namespace PortalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Publisher
 *
 * @ORM\Table(name="publishers")
 * @ORM\Entity(repositoryClass="PortalBundle\Repository\PublisherRepository")
 * @UniqueEntity("name")
 */
class Publisher
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     * @Assert\NotBlank(
     *  message = "Publisher name cannot be blank."
     * )      
     */
    private $name;

    // -----------------------------------------
    //
    //    Relations
    //
    // -----------------------------------------

    /**
    * @ORM\OneToMany(targetEntity="Book", mappedBy="publisher")
    */
    private $books;

    public function __construct() {
        $this->books = new ArrayCollection();
    }

    // -----------------------------------------
    //
    //    Setters / getters
    //
    // ----------------------------------------- 

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Publisher
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add books
     *
     * @param \PortalBundle\Entity\Book $books
     * @return Publisher
     */
    public function addBook(\PortalBundle\Entity\Book $books)
    {
        $this->books[] = $books;

        return $this;
    }

    /**
     * Remove books
     *
     * @param \PortalBundle\Entity\Book $books
     */
    public function removeBook(\PortalBundle\Entity\Book $books)
    {
        $this->books->removeElement($books);
    }

    /**
     * Get books
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBooks()
    {
        return $this->books;
    }
}
