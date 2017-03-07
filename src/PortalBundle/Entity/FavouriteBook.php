<?php

namespace PortalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
    * @ORM\ManyToMany(targetEntity="Book", inversedBy="favouriteBooks")
    * @ORM\JoinTable(name="favouriteBooks_books")
    */
    private $books;

    /**
    * @ORM\ManyToMany(targetEntity="Reader", inversedBy="favouriteBooks")
    * @ORM\JoinTable(name="favouriteBooks_readers")
    */
    private $readers;

    public function __construct() {
        $this->books = new ArrayCollection();
        $this->reviews = new ArrayCollection();
    }

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
}

