<?php

namespace PortalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Favourite
 *
 * @ORM\Table(name="favouriteBooks")
 * @ORM\Entity(repositoryClass="PortalBundle\Repository\FavouriteBookRepository")
 */
class FavouriteBook
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;   

    // -----------------------------------------
    //
    //    Relations
    //
    // -----------------------------------------

    /**
     * @ORM\ManyToOne(targetEntity="Reader", inversedBy="favouriteBooks")
     * @ORM\JoinColumn(name="readerId", referencedColumnName="id")
     */
    private $reader;

    /**
     * @ORM\ManyToOne(targetEntity="Book", inversedBy="favouriteBooks")
     * @ORM\JoinColumn(name="bookId", referencedColumnName="id")
     */
    private $book;

    // -----------------------------------------
    //
    //    Setters / getters
    //
    // -----------------------------------------

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set reader
     *
     * @param \PortalBundle\Entity\Reader $reader
     *
     * @return FavouriteBook
     */
    public function setReader(\PortalBundle\Entity\Reader $reader = null)
    {
        $this->reader = $reader;

        return $this;
    }

    /**
     * Get reader
     *
     * @return \PortalBundle\Entity\Reader
     */
    public function getReader()
    {
        return $this->reader;
    }

    /**
     * Set book
     *
     * @param \PortalBundle\Entity\Book $book
     *
     * @return FavouriteBook
     */
    public function setBook(\PortalBundle\Entity\Book $book = null)
    {
        $this->book = $book;

        return $this;
    }

    /**
     * Get book
     *
     * @return \PortalBundle\Entity\Book
     */
    public function getBook()
    {
        return $this->book;
    }
}
