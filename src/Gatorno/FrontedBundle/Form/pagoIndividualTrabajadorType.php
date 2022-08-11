<?php

namespace Gatorno\FrontedBundle\Form;

use Gatorno\FrontedBundle\Repository;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PagoIndividualTrabajadorType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder //fecha  monto montivo trabajador
            ->add('fechaDePago','date')
            ->add('salario')
            ->add('info', 'hidden', array('mapped' => false,))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
//        $resolver->setDefaults(array(
//            'data_class' => 'Gatorno\FrontedBundle\Entity\PagoTrabajador'
//        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'pagoIndividualTrabajador';
    }
}
