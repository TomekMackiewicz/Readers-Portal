<?php

namespace PortalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Quote
 *
 * @ORM\Table(name="quotes")
 * @ORM\Entity(repositoryClass="PortalBundle\Repository\QuoteRepository")
 */
class Quote
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
     * @ORM\Column(name="contents", type="text")
     */
    private $contents;

    // -----------------------------------------
    //
    //    Relations
    //
    // -----------------------------------------

    /**
    * @ORM\ManyToOne(targetEntity="Reader", inversedBy="quotes")
    * @ORM\JoinColumn(name="readerId", referencedColumnName="id", onDelete="CASCADE")   
    */
    private $reader;

    /**
    * @ORM\ManyToOne(targetEntity="Author", inversedBy="quotes")
    * @ORM\JoinColumn(name="authorId", referencedColumnName="id", onDelete="CASCADE")   
    */
    private $author;

    /**
    * @ORM\ManyToOne(targetEntity="Book", inversedBy="quotes")
    * @ORM\JoinColumn(name="bookId", referencedColumnName="id", onDelete="CASCADE")   
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
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set contents
     *
     * @param string $contents
     * @return Quote
     */
    public function setContents($contents)
    {
        $this->contents = $contents;

        return $this;
    }

    /**
     * Get contents
     *
     * @return string 
     */
    public function getContents()
    {
        return $this->contents;
    }

    /**
     * Set reader
     *
     * @param \PortalBundle\Entity\Reader $reader
     * @return Quote
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
     * Set author
     *
     * @param \PortalBundle\Entity\Author $author
     * @return Quote
     */
    public function setAuthor(\PortalBundle\Entity\Author $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \PortalBundle\Entity\Author 
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set book
     *
     * @param \PortalBundle\Entity\Book $book
     * @return Quote
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
