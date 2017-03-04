<?php

namespace PortalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Review
 *
 * @ORM\Table(name="reviews")
 * @ORM\Entity(repositoryClass="PortalBundle\Repository\ReviewRepository")
 */
class Review
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

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="publishDate", type="datetime")
     * @Assert\Date()(
     *  message = "Invalid value (expected: date format)."
     * )      
     */
    private $publishDate;

    // -----------------------------------------
    //
    //    Relations
    //
    // -----------------------------------------

    /**
    * @ORM\ManyToOne(targetEntity="Reader", inversedBy="reviews")
    * @ORM\JoinColumn(name="readerId", referencedColumnName="id", onDelete="CASCADE")
    */
    private $reader;

    /**
    * @ORM\ManyToOne(targetEntity="Book", inversedBy="reviews")
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
     * @return Review
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
     * Set publishDate
     *
     * @param \DateTime $publishDate
     * @return Review
     */
    public function setPublishDate($publishDate)
    {
        $this->publishDate = $publishDate;

        return $this;
    }

    /**
     * Get publishDate
     *
     * @return \DateTime 
     */
    public function getPublishDate()
    {
        return $this->publishDate;
    }

    /**
     * Set reader
     *
     * @param \PortalBundle\Entity\Reader $reader
     * @return Review
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
     * @return Review
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
