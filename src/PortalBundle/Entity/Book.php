<?php

namespace PortalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Book
 *
 * @ORM\Table(name="books")
 * @ORM\Entity(repositoryClass="PortalBundle\Repository\BookRepository")
 * @Vich\Uploadable
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
     * @ORM\Column(name="isbn", type="string", length=13, nullable=true)
     * @Assert\Isbn(
     *     message = "This value should match ISBN format."
     * )        
     */
    private $isbn;

    /**
     * @var string
     * 
     * @Vich\UploadableField(mapping="book_image", fileNameProperty="imageName")
     * 
     * @var File      
     */
    private $coverImage;

    /**
     * @ORM\Column(name="imageName", type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $imageName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="publishDate", type="date", nullable=true)
     * @Assert\Date()(
     *  message = "Invalid value (expected: date format)."
     * )          
     */     
    private $publishDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="addDate", type="date", nullable=true)
     * @Assert\Date()(
     *  message = "Invalid value (expected: date format)."
     * )          
     */     
    private $addDate;

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

    /**
     * @ORM\OneToMany(targetEntity="FavouriteBook", mappedBy="book", cascade={"persist"})
     */
    private $favouriteBooks;

    /**
     * @ORM\OneToMany(targetEntity="WantedBook", mappedBy="book", cascade={"persist"})
     */
    private $wantedBooks;
 
    /**
     * @ORM\OneToMany(targetEntity="CurrentBook", mappedBy="book", cascade={"persist"})
     */
    private $currentBooks;

    public function __construct() {
        $this->readers = new ArrayCollection();
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
     * Set isbn
     *
     * @param string $isbn
     * @return Book
     */
    public function setIsbn($isbn)
    {
        $this->isbn = $isbn;

        return $this;
    }

    /**
     * Get isbn
     *
     * @return string 
     */
    public function getIsbn()
    {
        return $this->isbn;
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

    /**
     * Set addDate
     *
     * @param \DateTime $addDate
     * @return Book
     */
    public function setAddDate($addDate)
    {
        $this->addDate = $addDate;

        return $this;
    }

    /**
     * Get addDate
     *
     * @return \DateTime 
     */
    public function getAddDate()
    {
        return $this->addDate;
    }

    /**
     * Set author
     *
     * @param \PortalBundle\Entity\Author $author
     * @return Book
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
     * Set translator
     *
     * @param \PortalBundle\Entity\Translator $translator
     * @return Book
     */
    public function setTranslator(\PortalBundle\Entity\Translator $translator = null)
    {
        $this->translator = $translator;

        return $this;
    }

    /**
     * Get translator
     *
     * @return \PortalBundle\Entity\Translator 
     */
    public function getTranslator()
    {
        return $this->translator;
    }

    /**
     * Set publisher
     *
     * @param \PortalBundle\Entity\Publisher $publisher
     * @return Book
     */
    public function setPublisher(\PortalBundle\Entity\Publisher $publisher = null)
    {
        $this->publisher = $publisher;

        return $this;
    }

    /**
     * Get publisher
     *
     * @return \PortalBundle\Entity\Publisher 
     */
    public function getPublisher()
    {
        return $this->publisher;
    }

    /**
     * Add readers
     *
     * @param \PortalBundle\Entity\Reader $readers
     * @return Book
     */
    public function addReader(\PortalBundle\Entity\Reader $readers)
    {
        $this->readers[] = $readers;

        return $this;
    }

    /**
     * Remove readers
     *
     * @param \PortalBundle\Entity\Reader $readers
     */
    public function removeReader(\PortalBundle\Entity\Reader $readers)
    {
        $this->readers->removeElement($readers);
    }

    /**
     * Get readers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getReaders()
    {
        return $this->readers;
    }

    /**
     * Add reviews
     *
     * @param \PortalBundle\Entity\Review $reviews
     * @return Book
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
     * @return Book
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
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     * @return Book
     */
    public function setCoverImage(File $image = null)
    {
        $this->coverImage = $image;

        if ($image) {
            $this->publishDate = new \DateTimeImmutable();
        }

        return $this;
    }

    /**
     * Get coverImage
     *
     * @return File|null 
     */
    public function getCoverImage()
    {
        return $this->coverImage;
    }

    /**
     * Set imageName
     *
     * @param string $imageName
     * @return Book
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
     * Add favouriteBook
     *
     * @param \PortalBundle\Entity\FavouriteBook $favouriteBook
     *
     * @return Book
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
     * @return Book
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
     * Get WantedBooks
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
     * @return Book
     */
    public function addCurrentBook(\PortalBundle\Entity\CurrentBook $currentBook)
    {
        $this->currentBooks[] = $currentBook;

        return $this;
    }

    /**
     * Remove currentBook
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
