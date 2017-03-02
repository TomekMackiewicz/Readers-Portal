<?php

namespace PortalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Reader
 *
 * @ORM\Table(name="readers")
 * @ORM\Entity(repositoryClass="PortalBundle\Repository\ReaderRepository")
 * @UniqueEntity("nick")
 */
class Reader
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
     * @ORM\Column(name="nick", type="string", length=255, unique=true)
     */
    private $nick;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;

    // -----------------------------------------
    //
    //    Relations
    //
    // -----------------------------------------

    /**
    * @ORM\ManyToMany(targetEntity="Book", inversedBy="readers")
    * @ORM\JoinTable(name="readers_books")
    */
    private $books;

    /**
    * @ORM\ManyToMany(targetEntity="Author", inversedBy="readers")
    * @ORM\JoinTable(name="readers_authors")
    */
    private $authors;
    
    /**
    * @ORM\OneToMany(targetEntity="Review", mappedBy="reader")
    */
    private $reviews;

    /**
    * @ORM\OneToMany(targetEntity="Rating", mappedBy="reader")
    */
    private $ratings;
    
    public function __construct() {
        $this->books = new ArrayCollection();
        $this->authors = new ArrayCollection();
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
     * Set nick
     *
     * @param string $nick
     * @return Reader
     */
    public function setNick($nick)
    {
        $this->nick = $nick;

        return $this;
    }

    /**
     * Get nick
     *
     * @return string 
     */
    public function getNick()
    {
        return $this->nick;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Reader
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
     * Set image
     *
     * @param string $image
     * @return Reader
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }
}
