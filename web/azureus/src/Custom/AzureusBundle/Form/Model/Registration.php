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
     * @Assert\NotBlank()
     * @Assert\True()
     */
    protected $termsAccepted;

    public function setUser(User $user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
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