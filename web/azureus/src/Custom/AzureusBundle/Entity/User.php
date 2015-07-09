<?php

namespace Custom\AzureusBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * User
 *
 * @ORM\Table()
 * @ORM\Entity
 * @UniqueEntity("username")
 */
class User implements UserInterface {

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
     * @ORM\Column(name="username", type="string", length=30)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=64)
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity="Art", mappedBy="owner")
     */
    private $gallery;

    /**
     * @var UserInfo
     * 
     * @ORM\OneToOne(targetEntity="UserInfo", mappedBy="owner", cascade={"persist", "remove"})
     * */
    private $info;

    /**
     * @ORM\OneToMany(targetEntity="Post", mappedBy="owner")
     */
    private $journal;

    /**
     * @ORM\ManyToMany(targetEntity="Art", inversedBy="favourites")
     * @ORM\JoinTable(name="users_favourites")
     * */
    private $favourites;

    function __construct() {
        $this->favourites = new \Doctrine\Common\Collections\ArrayCollection();
        $this->journal = new \Doctrine\Common\Collections\ArrayCollection();
        $this->gallery = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username) {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password) {
        $this->password = password_hash($password, PASSWORD_BCRYPT);

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword() {
        return $this->password;
    }

    public function __toString() {
        return $this->username;
    }

    public function getSalt() {
        return null;
    }

    public function getRoles() {
        return array('ROLE_USER');
    }

    public function eraseCredentials() {
        
    }

    /**
     * Add gallery
     *
     * @param \Custom\AzureusBundle\Entity\Art $gallery
     * @return User
     */
    public function addGallery(\Custom\AzureusBundle\Entity\Art $gallery) {
        $this->gallery[] = $gallery;

        return $this;
    }

    /**
     * Remove gallery
     *
     * @param \Custom\AzureusBundle\Entity\Art $gallery
     */
    public function removeGallery(\Custom\AzureusBundle\Entity\Art $gallery) {
        $this->gallery->removeElement($gallery);
    }

    /**
     * Get gallery
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGallery() {
        return $this->gallery;
    }

    /**
     * Set info
     *
     * @param \Custom\AzureusBundle\Entity\UserInfo $info
     * @return User
     */
    public function setInfo(\Custom\AzureusBundle\Entity\UserInfo $info = null) {
        $this->info = $info;

        return $this;
    }

    /**
     * Get info
     *
     * @return \Custom\AzureusBundle\Entity\UserInfo 
     */
    public function getInfo() {
        return $this->info;
    }

    /**
     * Add journal
     *
     * @param \Custom\AzureusBundle\Entity\Post $journal
     * @return User
     */
    public function addJournal(\Custom\AzureusBundle\Entity\Post $journal) {
        $this->journal[] = $journal;

        return $this;
    }

    /**
     * Remove journal
     *
     * @param \Custom\AzureusBundle\Entity\Post $journal
     */
    public function removeJournal(\Custom\AzureusBundle\Entity\Post $journal) {
        $this->journal->removeElement($journal);
    }

    /**
     * Get journal
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getJournal() {
        return $this->journal;
    }

    /**
     * Add favourites
     *
     * @param \Custom\AzureusBundle\Entity\Art $favourites
     * @return User
     */
    public function addFavourite(\Custom\AzureusBundle\Entity\Art $favourites) {
        $this->favourites[] = $favourites;

        return $this;
    }

    /**
     * Remove favourites
     *
     * @param \Custom\AzureusBundle\Entity\Art $favourites
     */
    public function removeFavourite(\Custom\AzureusBundle\Entity\Art $favourites) {
        $this->favourites->removeElement($favourites);
    }

    /**
     * Get favourites
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFavourites() {
        return $this->favourites;
    }

}
