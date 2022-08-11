<?php

namespace Gatorno\FrontedBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class appUserEditType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')//nombre  password cargo
            ->add('password','password',array('required' => false))
            ->add('cargo','choice', array('choices'=>array('ROLE_USUARIO'=>'Secretaria','ROLE_ADMIN'=>'Propietario')))
            //->add('salt')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Gatorno\FrontedBundle\Entity\appUser'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gatorno_frontedbundle_appuserEdit';
    }
}
