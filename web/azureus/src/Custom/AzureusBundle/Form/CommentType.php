<?php
namespace Custom\AzureusBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CommentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $is_admin = $options['is_admin'];
        
        $builder
            ->add('content');
        
        if($is_admin) {
             $builder
                ->add('owner');
        }
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Custom\AzureusBundle\Entity\Comment',
            'is_admin' => null
        ));
    }
    /**
     * @return string
     */
    public function getName()
    {
        return 'custom_azureusbundle_comment';
    }
}