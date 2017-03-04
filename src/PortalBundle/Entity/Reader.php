<?php

namespace PortalBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Reader
 *
 * @ORM\Table(name="readers")
 * @ORM\Entity(repositoryClass="PortalBundle\Repository\ReaderRepository")
 * @Vich\Uploadable
 * @UniqueEntity("nick")
 */
class Reader extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

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

    /**
     * @var string
     */
    private $imageFile;

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
        parent::__construct();
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

    /**
     * Add books
     *
     * @param \PortalBundle\Entity\Book $books
     * @return Reader
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

    /**
     * Add authors
     *
     * @param \PortalBundle\Entity\Author $authors
     * @return Reader
     */
    public function addAuthor(\PortalBundle\Entity\Author $authors)
    {
        $this->authors[] = $authors;

        return $this;
    }

    /**
     * Remove authors
     *
     * @param \PortalBundle\Entity\Author $authors
     */
    public function removeAuthor(\PortalBundle\Entity\Author $authors)
    {
        $this->authors->removeElement($authors);
    }

    /**
     * Get authors
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAuthors()
    {
        return $this->authors;
    }

    /**
     * Add reviews
     *
     * @param \PortalBundle\Entity\Review $reviews
     * @return Reader
     */
    public function addReview(\PortalBundle\Entity\Review $reviews)
    {
        $this->reviews[] = $reviews;

        return $this;
    }

    /**
     * Remove reviews
     *
     * @param \PortalBundle\Entity\Review $reviews
     */
    public function removeReview(\PortalBundle\Entity\Review $reviews)
    {
        $this->reviews->removeElement($reviews);
    }

    /**
     * Get reviews
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getReviews()
    {
        return $this->reviews;
    }

    /**
     * Add ratings
     *
     * @param \PortalBundle\Entity\Rating $ratings
     * @return Reader
     */
    public function addRating(\PortalBundle\Entity\Rating $ratings)
    {
        $this->ratings[] = $ratings;

        return $this;
    }

    /**
     * Remove ratings
     *
     * @param \PortalBundle\Entity\Rating $ratings
     */
    public function removeRating(\PortalBundle\Entity\Rating $ratings)
    {
        $this->ratings->removeElement($ratings);
    }

    /**
     * Get ratings
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRatings()
    {
        return $this->ratings;
    }
}
