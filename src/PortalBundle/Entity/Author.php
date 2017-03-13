<?php

namespace PortalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Author
 *
 * @ORM\Table(name="authors")
 * @ORM\Entity(repositoryClass="PortalBundle\Repository\AuthorRepository")
 * @Vich\Uploadable
 */
class Author
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
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank(
     *  message = "Author name cannot be blank."
     * )     
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * 
     * @Vich\UploadableField(mapping="author_image", fileNameProperty="imageName")
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
    * @ORM\OneToMany(targetEntity="Book", mappedBy="author")
    */
    private $books;

    /**
    * @ORM\OneToMany(targetEntity="Quote", mappedBy="author")
    */
    private $quotes;

    /**
    * @ORM\ManyToMany(targetEntity="Reader", mappedBy="authors")
    */
    private $readers;

    public function __construct() {
        $this->books = new ArrayCollection();
        $this->readers = new ArrayCollection();
        $this->quotes = new ArrayCollection();
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
     * @return Author
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
     * Set description
     *
     * @param string $description
     * @return Author
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
     * @return Author
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
     * @return Author
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
     * @return Author
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
     * Add quotes
     *
     * @param \PortalBundle\Entity\Quote $quotes
     * @return Author
     */
    public function addQuote(\PortalBundle\Entity\Quote $quotes)
    {
        $this->quotes[] = $quotes;

        return $this;
    }

    /**
     * Remove quotes
     *
     * @param \PortalBundle\Entity\Quote $quotes
     */
    public function removeQuote(\PortalBundle\Entity\Quote $quotes)
    {
        $this->quotes->removeElement($quotes);
    }

    /**
     * Get quotes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getQuotes()
    {
        return $this->quotes;
    }

    /**
     * Add readers
     *
     * @param \PortalBundle\Entity\Reader $readers
     * @return Author
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
}
