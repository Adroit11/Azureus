<?php
namespace Custom\AzureusBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity()
 */
class ArtComment extends Comment {
    
     /**
     * @ORM\ManyToOne(targetEntity="Art", inversedBy="comments", cascade={"remove"})
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $parent;

    /**
     * Set parent
     *
     * @param \Custom\AzureusBundle\Entity\Art $parent
     * @return ArtComment
     */
    public function setParent(\Custom\AzureusBundle\Entity\Art $parent = null)
    {
        $this->parent = $parent;
        $this->parent->addComment($this);
                
        return $this;
    }

    /**
     * Get parent
     *
     * @return \Custom\AzureusBundle\Entity\Art 
     */
    public function getParent()
    {
        return $this->parent;
    }
}
