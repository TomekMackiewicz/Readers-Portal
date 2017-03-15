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
     * 
     * @Vich\UploadableField(mapping="reader_image", fileNameProperty="imageName")
     * @Assert\File(
     *     maxSize = "1024k",
     *     mimeTypes = {"image/jpeg", "image/png"},
     *     mimeTypesMessage = "Please upload a valid image type (jpg)"
     * )     
     * 
     * @var File      
     */
    private $image;

    /**
     * @ORM\Column(name="imageName", type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $imageName;

    /**
     * @var \Date
     *
     * @ORM\Column(name="updatedAt", type="date", nullable=true)         
     */     
    private $updatedAt;

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

    /**
     * @ORM\OneToMany(targetEntity="FavouriteBook", mappedBy="reader", cascade={"persist"})
     */
    private $favouriteBooks;

    /**
     * @ORM\OneToMany(targetEntity="WantedBook", mappedBy="reader", cascade={"persist"})
     */
    private $wantedBooks;

    /**
     * @ORM\OneToMany(targetEntity="CurrentBook", mappedBy="reader", cascade={"persist"})
     */
    private $currentBooks;
    
    public function __construct() {
        parent::__construct();
        $this->books = new ArrayCollection();
        $this->authors = new ArrayCollection();
        $this->reviews = new ArrayCollection();
        $this->ratings = new ArrayCollection();
        $this->favouriteBooks = new ArrayCollection();
        $this->wantedBooks = new ArrayCollection();
        $this->currentBooks = new ArrayCollection();
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
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     * @return Reader
     */   
    public function setImage(File $image = null)
    {
        $this->image = $image;

        if ($image) {
            $this->updatedAt = new \DateTimeImmutable();;
        }

        return $this;
    }

    /**
     * Get image
     *
     * @return File|null 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set imageName
     *
     * @param string $imageName
     * @return Reader
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * Get imageName
     *
     * @return string 
     */
    public function getImageName()
    {
        return $this->imageName;
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

    /**
     * Add favouriteBook
     *
     * @param \PortalBundle\Entity\FavouriteBook $favouriteBook
     *
     * @return Reader
     */
    public function addFavouriteBook(\PortalBundle\Entity\FavouriteBook $favouriteBook)
    {
        $this->favouriteBooks[] = $favouriteBook;

        return $this;
    }

    /**
     * Remove favouriteBook
     *
     * @param \PortalBundle\Entity\FavouriteBook $favouriteBook
     */
    public function removeFavouriteBook(\PortalBundle\Entity\FavouriteBook $favouriteBook)
    {
        $this->favouriteBooks->removeElement($favouriteBook);
    }

    /**
     * Get favouriteBooks
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFavouriteBooks()
    {
        return $this->favouriteBooks;
    }

    /**
     * Add wantedBook
     *
     * @param \PortalBundle\Entity\WantedBook $wantedBook
     *
     * @return Reader
     */
    public function addWantedBook(\PortalBundle\Entity\WantedBook $wantedBook)
    {
        $this->wantedBooks[] = $wantedBook;

        return $this;
    }

    /**
     * Remove wantedBook
     *
     * @param \PortalBundle\Entity\WantedBook $wantedBook
     */
    public function removeWantedBook(\PortalBundle\Entity\WantedBook $wantedBook)
    {
        $this->wantedBooks->removeElement($wantedBook);
    }

    /**
     * Get wantedBooks
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getWantedBooks()
    {
        return $this->wantedBooks;
    }

    /**
     * Add currentBook
     *
     * @param \PortalBundle\Entity\CurrentBook $currentBook
     *
     * @return Reader
     */
    public function addCurrentBook(\PortalBundle\Entity\CurrentBook $currentBook)
    {
        $this->currentBooks[] = $currentBook;

        return $this;
    }

    /**
     * Remove CurrentBook
     *
     * @param \PortalBundle\Entity\CurrentBook $currentBook
     */
    public function removeCurrentBook(\PortalBundle\Entity\CurrentBook $currentBook)
    {
        $this->currentBooks->removeElement($currentBook);
    }

    /**
     * Get CurrentBooks
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCurrentBooks()
    {
        return $this->currentBooks;
    }

}
