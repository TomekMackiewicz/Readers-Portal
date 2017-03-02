<?php

namespace PortalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Rating
 *
 * @ORM\Table(name="ratings")
 * @ORM\Entity(repositoryClass="PortalBundle\Repository\RatingRepository")
 */
class Rating
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
     * @var int
     *
     * @ORM\Column(name="rate", type="integer")
     * @Assert\Type(
     *   type="integer",
     *   message="The value {{ value }} is not a valid {{ type }}."
     * )     
     */
    private $rate;

    // -----------------------------------------
    //
    //    Relations
    //
    // -----------------------------------------

    /**
    * @ORM\ManyToOne(targetEntity="Reader", inversedBy="ratings")
    * @ORM\JoinColumn(name="readerId", referencedColumnName="id", onDelete="CASCADE")
    */
    private $reader;

    /**
    * @ORM\ManyToOne(targetEntity="Book", inversedBy="ratings")
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
     * Set rate
     *
     * @param integer $rate
     * @return Rating
     */
    public function setRate($rate)
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * Get rate
     *
     * @return integer 
     */
    public function getRate()
    {
        return $this->rate;
    }
}
