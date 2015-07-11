<?php

namespace Custom\AzureusBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Post
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Post
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
     * @ORM\ManyToOne(targetEntity="User", inversedBy="journal")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id")
     */
    private $owner;
    
    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;
    
    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;
    
    /**
     * @ORM\OneToMany(targetEntity="PostComment", mappedBy="parent")
     */
    private $comments;
        
    /**
     * @var \DateTime date
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="favourite_posts")
     **/
    private $favourite_posts;
    
    function __construct() {
        //$this->date = new \DateTime();
        $this->comments = new \Doctrine\Common\Collections\ArrayCollection();
        $this->favourite_posts = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set title
     *
     * @param string $title
     * @return Post
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
     * Set content
     *
     * @param string $content
     * @return Post
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Post
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
     * @return Post
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
     * Add comments
     *
     * @param \Custom\AzureusBundle\Entity\PostComment $comments
     * @return Post
     */
    public function addComment(\Custom\AzureusBundle\Entity\PostComment $comments)
    {
        $this->comments[] = $comments;

        return $this;
    }

    /**
     * Remove comments
     *
     * @param \Custom\AzureusBundle\Entity\PostComment $comments
     */
    public function removeComment(\Custom\AzureusBundle\Entity\PostComment $comments)
    {
        $this->comments->removeElement($comments);
    }

    /**
     * Add favourites
     *
     * @param \Custom\AzureusBundle\Entity\User $favourite_posts
     * @return Post
     */
    public function addFavourite(\Custom\AzureusBundle\Entity\User $favourite_posts)
    {
        $this->favourite_posts[] = $favourite_posts;

        return $this;
    }

    /**
     * Remove favourites
     *
     * @param \Custom\AzureusBundle\Entity\User $favourite_posts
     */
    public function removeFavourite(\Custom\AzureusBundle\Entity\User $favourite_posts)
    {
        $this->favourite_posts->removeElement($favourite_posts);
    }

    /**
     * Get favourites
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFavourites()
    {
        return $this->favourite_posts;
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getComments()
    {
        return $this->comments;
    }
    
    public function getClassName()
    {
        return (new \ReflectionClass($this))->getShortName();
    }
}
