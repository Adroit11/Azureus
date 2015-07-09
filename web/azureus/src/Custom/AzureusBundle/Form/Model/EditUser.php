<?php
// src/Acme/AccountBundle/Form/Model/Registration.php
namespace Custom\AzureusBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

use Custom\AzureusBundle\Entity\User;

class EditUser
{
    /**
     * @Assert\Type(type="Custom\AzureusBundle\Entity\User")
     * @Assert\Valid()
     */
    protected $user;
    
    /**
     * @Assert\Type(type="Custom\AzureusBundle\Entity\UserInfo")
     * @Assert\Valid()
     */
    protected $user_info;

    public function setUser(User $user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }
    
    public function getUserInfo()
    {
        return $this->user_info;
    }
}
    
?>