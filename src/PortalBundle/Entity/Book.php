<?php

namespace PortalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Book
 *
 * @ORM\Table(name="books")
 * @ORM\Entity(repositoryClass="PortalBundle\Repository\BookRepository")
 */
class Book
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
     * @ORM\Column(name="title", type="string", length=255)
     * @Assert\NotBlank(
     *  message = "Title cannot be blank."
     * )      
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="coverImage", type="string", length=255, nullable=true)
     */
    private $coverImage;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="publishDate", type="date", nullable=true)
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
    * @ORM\ManyToOne(targetEntity="Author", inversedBy="books")
    * @ORM\JoinColumn(name="authorId", referencedColumnName="id", onDelete="CASCADE")   
    */
    private $author;

    /**
    * @ORM\ManyToOne(targetEntity="Translator", inversedBy="books")
    * @ORM\JoinColumn(name="translatorId", referencedColumnName="id", nullable=true, onDelete="SET NULL")   
    */
    private $translator;

    /**
    * @ORM\ManyToOne(targetEntity="Publisher", inversedBy="books")
    * @ORM\JoinColumn(name="publisherId", referencedColumnName="id", nullable=true, onDelete="SET NULL")   
    */
    private $publisher;

    /**
    * @ORM\ManyToMany(targetEntity="Reader", mappedBy="books")
    */
    private $readers;

    /**
    * @ORM\OneToMany(targetEntity="Review", mappedBy="book")
    */
    private $reviews;

    /**
    * @ORM\OneToMany(targetEntity="Rating", mappedBy="book")
    */
    private $ratings;
    
    public function __construct() {
        $this->readers = new ArrayCollection();
        $this->reviews = new ArrayCollection();
        $this->ratings = new ArrayCollection();
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
     * Set title
     *
     * @param string $title
     * @return Book
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Book
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set coverImage
     *
     * @param string $coverImage
     * @return Book
     */
    public function setCoverImage($coverImage)
    {
        $this->coverImage = $coverImage;

        return $this;
    }

    /**
     * Get coverImage
     *
     * @return string 
     */
    public function getCoverImage()
    {
        return $this->coverImage;
    }

    /**
     * Set publishDate
     *
     * @param \DateTime $publishDate
     * @return Book
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
}
