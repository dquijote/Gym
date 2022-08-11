<?php

namespace Gatorno\FrontedBundle\Form\Front;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TrabajadorType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('apellidos')
            ->add('fechaDeIngreso','date', array(
                'format' => 'dd/MM/yyyy',
                'widget' => 'single_text'))
            ->add('fechaDePago','date', array(
                'format' => 'dd/MM/yyyy',
                'widget' => 'single_text'))
            ->add('cargo',null,array(
                'empty_value' => 'Seleccione un cargo',
                'required' => true,
            ))
            ->add('sexo','choice', array('choices'=>array('Masculino'=>'Masculino','Femenino'=>'Femenino')))
            ->add('foto','file',array('required'=>false))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Gatorno\FrontedBundle\Entity\Trabajador'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gatorno_frontedbundle_trabajador';
    }
}
