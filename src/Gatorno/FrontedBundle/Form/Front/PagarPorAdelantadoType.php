<?php

namespace Gatorno\FrontedBundle\Form\Front;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PagarPorAdelantadoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Jan','checkbox',array('label'=>false,'required'=>false))
            ->add('Feb','checkbox',array('label'=>false,'required'=>false))
            ->add('Mar','checkbox',array('label'=>false,'required'=>false))
            ->add('Apr','checkbox',array('label'=>false,'required'=>false))
            ->add('May','checkbox',array('label'=>false,'required'=>false))
            ->add('Jun','checkbox',array('label'=>false,'required'=>false))
            ->add('Jul','checkbox',array('label'=>false,'required'=>false))
            ->add('Aug','checkbox',array('label'=>false,'required'=>false))
            ->add('Sep','checkbox',array('label'=>false,'required'=>false))
            ->add('Oct','checkbox',array('label'=>false,'required'=>false))
            ->add('Nov','checkbox',array('label'=>false,'required'=>false))
            ->add('Dec','checkbox',array('label'=>false,'required'=>false))

        ;

    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
      ;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'pagoAdelantado';
    }
}
