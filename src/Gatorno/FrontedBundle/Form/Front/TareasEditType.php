<?php

namespace Gatorno\FrontedBundle\Form\Front;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TareasEditType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('nombre','text')
            //->add('fechaDeCreada','text',array('attr'=>array('class'=>'input-mini','id'=>'maskedDate')))
            ->add('fechaDeCumplimiento','date', array(
                'format' => 'dd-MM-yyyy',
                'widget' => 'single_text'))
            // ->add('fechaDePago','text')
            ->add('descripcion','textarea',array('required' => false))
            ->add('asignadaToTrabajador','entity',array(
                'class'=>'FrontedBundle:Trabajador',
                'empty_value' => 'Seleccione un trabajador',
                'property' => 'nombre'))
            ->add('creadaPor','entity',array(
                'class'=>'FrontedBundle:Trabajador',
                'property' => 'nombre',
                //'empty_value' => 'Seleccione un propietario',
                'query_builder' => function(EntityRepository $er) {
                        return $er->findPropietario()
                            //->orderBy('u.nombre', 'ASC')
                            ;
                    }
            ))
           ->add('cumplida', 'checkbox',array(
                'required'=>false,
            ))


           // ->add('costoDeservicio','choice', array('choices'=>array('0'=>0,'3'=>3,'6'=>6)))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Gatorno\FrontedBundle\Entity\Tarea'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gatorno_frontedbundle_tareaEdit';
    }
}
