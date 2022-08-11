<?php

namespace Gatorno\FrontedBundle\Form\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class ClienteFiltroType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fechaDeIngreso', "date", array(
                'mapped' => false,
                'required' => false
            ) )
            ->add('fechaDeIngresoFin', "date", array(
                'mapped' => false,
                'required' => false
    )) //fin de intervalo de "Fecha de ingreso"
            ->add('fechaDePago', "date", array(
                'mapped' => false,
                'required' => false
            ))
            ->add('fechaDePagoFin', "date", array(
                'mapped' => false,
                'required' => false
            )) //fin de intervalo de "Fecha de pago"

            ->add('tipo','entity',array(
                'class'=>'FrontedBundle:TipoCliente',
                'property' => 'tipo',
                'required' => false
            ))
            ->add('sexo','choice', array('choices'=>array('Masculino'=>'Masculino','Femenino'=>'Femenino'),
                'required' => false))
            ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
//        $resolver->setDefaults(array(
//            'data_class' => 'Gatorno\FrontedBundle\Entity\Cliente'
//        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gatorno_frontedbundle_cliente_filtro';
    }
}
