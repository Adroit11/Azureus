<?php
// src/Acme/AccountBundle/Form/Model/Registration.php
namespace Custom\AzureusBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

use Custom\AzureusBundle\Entity\User;

class Registration
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

    /**
     * @Assert\NotBlank()
     * @Assert\True()
     */
    protected $termsAccepted;

    public function setUser(User $user)
    {
        $this->user = $user;
        $this->user_info->owner = $user;
        $this->user->info = $user_info;
    }

    public function getUser()
    {
        return $this->user;
    }
    
    public function getUserInfo()
    {
        return $this->user_info;
    }

    public function getTermsAccepted()
    {
        return $this->termsAccepted;
    }

    public function setTermsAccepted($termsAccepted)
    {
        $this->termsAccepted = (bool) $termsAccepted;
    }
}
    
?>