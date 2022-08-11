<?php

namespace Gatorno\FrontedBundle\Form;

use Gatorno\FrontedBundle\Repository;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GastosVariadosType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder //fecha  monto montivo trabajador
            ->add('fecha','date',array(
                'format' => 'dd/MM/yyyy',
                'widget' => 'single_text'))
            ->add('monto')
            ->add('montivo','textarea')
            ->add('trabajador',null,array(
                'required' => true,
                'empty_value' => 'Seleccione un propietario',
                'query_builder' => function(EntityRepository $er) {
                    return $er->findPropietario();
                    }
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Gatorno\FrontedBundle\Entity\GastosVariados'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gatorno_frontedbundle_gastosvariados';
    }
}
