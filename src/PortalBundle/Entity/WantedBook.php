<?php

namespace PortalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Wanted
 *
 * @ORM\Table(name="wantedBooks")
 * @ORM\Entity(repositoryClass="PortalBundle\Repository\WantedBookRepository")
 */
class WantedBook
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
     * @ORM\ManyToOne(targetEntity="Reader", inversedBy="wantedBooks")
     * @ORM\JoinColumn(name="readerId", referencedColumnName="id")
     */
    private $reader;

    /**
     * @ORM\ManyToOne(targetEntity="Book", inversedBy="wantedBooks")
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
     * @return WantedBook
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
     * @return WantedBook
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