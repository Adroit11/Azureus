<?php
namespace Custom\AzureusBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity()
 */
class PostComment extends Comment {   
    
     /**
     * @ORM\ManyToOne(targetEntity="Post", inversedBy="comments")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $parent;

    /**
     * Set parent
     *
     * @param \Custom\AzureusBundle\Entity\Post $parent
     * @return PostComment
     */
    public function setParent(\Custom\AzureusBundle\Entity\Post $parent = null)
    {
        $this->parent = $parent;
        $this->parent->addComment($this);

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Custom\AzureusBundle\Entity\Post 
     */
    public function getParent()
    {
        return $this->parent;
    }
}
