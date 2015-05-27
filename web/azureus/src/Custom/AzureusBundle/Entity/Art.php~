<?php

namespace Custom\AzureusBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Art
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Art
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255)
     */
    private $path;
    
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="gallery")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id")
     */
    private $owner;
    
    /**
     * @Assert\File(maxSize="6000000")
     */
    private $file;
    
    /**
     * @var date
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;
    
    
    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="favourites")
     **/
    private $favourites;


    function __construct() {
        $this->date = new \DateTime();
        $this->favourites = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set description
     *
     * @param string $description
     * @return Art
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
     * Set path
     *
     * @param string $path
     * @return Art
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Art
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set owner
     *
     * @param \Custom\AzureusBundle\Entity\User $owner
     * @return Art
     */
    public function setOwner(\Custom\AzureusBundle\Entity\User $owner = null)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner
     *
     * @return \Custom\AzureusBundle\Entity\User 
     */
    public function getOwner()
    {
        return $this->owner;
    }


    /**
     * Add favourites
     *
     * @param \Custom\AzureusBundle\Entity\User $favourites
     * @return Art
     */
    public function addFavourite(\Custom\AzureusBundle\Entity\User $favourites)
    {
        $this->favourites[] = $favourites;

        return $this;
    }

    /**
     * Remove favourites
     *
     * @param \Custom\AzureusBundle\Entity\User $favourites
     */
    public function removeFavourite(\Custom\AzureusBundle\Entity\User $favourites)
    {
        $this->favourites->removeElement($favourites);
    }

    /**
     * Get favourites
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFavourites()
    {
        return $this->favourites;
    }
}
