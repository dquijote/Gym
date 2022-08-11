<?php

namespace Gatorno\FrontedBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ClienteType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('clave')
            ->add('fechaDeIngreso')
            ->add('fechaDePago')
            ->add('nombre')
            ->add('apellidos')
            /*->add('tipo','choice', array('choices'=>array(
                'VIP'=>'VIP',
                'MP'=>'Mitad de Precio',
                'Full'=>'Full'
            )))*/
            ->add('tipo','entity',array(
                'class'=>'FrontedBundle:TipoCliente',
                'property' => 'tipo',
                //'empty_value' => 'Tipo de Cliente', //muestra el valor predeterminado en el select.
//                'query_builder' => function(EntityRepository $er) {
//                    return $er->findAll() // esta funcion es del repositorio del entity que se esta mostrando, hay que incluir "use Doctrine\ORM\EntityRepository;"
//
//                        // ->orderBy('u.username', 'ASC')
//                        //->orderBy('u.nombre', 'ASC')
//                        ;
//                }
            ))
            ->add('sexo','choice', array('choices'=>array('Masculino'=>'Masculino','Femenino'=>'Femenino')))
            ->add('servicio')
            //->add('costoDeservicio')
            ->add('foto','file',array('required'=>false,))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Gatorno\FrontedBundle\Entity\Cliente'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gatorno_frontedbundle_cliente';
    }
}
