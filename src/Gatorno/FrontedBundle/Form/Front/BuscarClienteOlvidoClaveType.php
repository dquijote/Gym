<?php

namespace Gatorno\FrontedBundle\Form\Front;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BuscarClienteOlvidoClaveType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre','text',array('label'=>false))
            ->add('apellido','text',array('label'=>false ))
        ;
//'mapped' => false,'required'=>false,
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
     {
      /*  /*$resolver->setDefaults(array(
             'data_class' => 'Gatorno\FrontedBundle\Entity\Cliente'
         ));*/
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'frontedbundle_buscar_cliente_olvido_clave';
    }
}
