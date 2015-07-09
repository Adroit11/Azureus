<?php

namespace Custom\AzureusBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserInfoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array( 'required' => true))
            ->add('surname', 'text', array( 'required' => false))
            ->add('bio', 'text', array( 'required' => false))
            ->add('country', 'text', array( 'required' => false))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Custom\AzureusBundle\Entity\UserInfo'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'custom_azureusbundle_userinfo';
    }
}
