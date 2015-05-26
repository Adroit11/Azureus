<?php
namespace Custom\AzureusBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use EWZ\Bundle\RecaptchaBundle\EWZRecaptchaBundle;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('user', new UserType());
        $builder->add(
            'terms',
            'checkbox',
            array('property_path' => 'termsAccepted')
        );    
        $builder->add('recaptcha', 'ewz_recaptcha');
        $builder->add('Register', 'submit');
    }

    public function getName()
    {
        return 'registration';
    }
}