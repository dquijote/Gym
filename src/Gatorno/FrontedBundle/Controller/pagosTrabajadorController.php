<?php

namespace Gatorno\FrontedBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Gatorno\FrontedBundle\Entity;
use Gatorno\FrontedBundle\Form;

/**
 * GastosVariados controller.
 *
 */
class pagosTrabajadorController extends Controller
{

    /**
     * Lista los trabajadores con opciones de pago
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FrontedBundle:Trabajador')->findAll();

        $gastosVariados = true;
        return $this->render('FrontedBundle:PagosTrabajador:index.html.twig', array(
            'entities' => $entities,
            //'gastosVariados'=>$gastosVariados,
        ));
    }

    /*
     * Se realiza un pago individual del trabajador
     */

    public function individualAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        //$entityPagoTrabajador = new Entity\PagoTrabajador();

        $entityTrabajador = $em->getRepository('FrontedBundle:Trabajador')->findOneBy(array('id'=>$id));
        if(!$entityTrabajador)
            throw $this->createNotFoundException('Imposible encontrar la entidad Trabajador.');

        $allTrabajador = $em->getRepository('FrontedBundle:Trabajador')->findall();


//        $data = new Entity\PagoTrabajador();
//        $data->setFechaDePago(new \DateTime('now'));
//        $data->setSalario($entityTrabajador->getCargo()->getSalario());
//        $data->setTrabajador($entityTrabajador);
        $data = array('fechaDePago'=>new \DateTime('now'),
            'salario'=>$entityTrabajador->getCargo()->getSalario(),
        );

        $form = $this->createForm(new Form\PagoIndividualTrabajadorType(), $data, array(
                'action' => $this->generateUrl('pago_trabajador_individual_save'),
                'method' => 'POST')
            );




        return $this->render('FrontedBundle:PagosTrabajador:pagoIndividual.html.twig',
            array('entityTrabajador'=>$entityTrabajador,
                'entities'=>$allTrabajador,
                'form'=>$form->createView(),
            )
        );
    }

    /**
     * Paga a un trabajador especifico en una fecha dada
     *
     */
    public function individualSaveAction(Request $peticion)
    {
        $em = $this->getDoctrine()->getManager();

        $formWeb = $peticion->get('pagoIndividualTrabajador');
        
        $entidad = new Entity\PagoTrabajador();
        $formulario = $this->createForm(new Form\PagoIndividualTrabajadorType(),$entidad);
        $formulario->handleRequest($peticion);


        $trabajador = $em->getRepository('FrontedBundle:Trabajador')->findOneBy(array('id'=>$formWeb['info']));
        var_dump($formWeb);
        if(!$trabajador)
            throw $this->createNotFoundException('Imposible encontrar la entidad Trabajador.');
        $dateForm = new \DateTime();
        $dateForm->setDate($formWeb['fechaDePago']['year'], $formWeb['fechaDePago']['month'],$formWeb['fechaDePago']['day']);

        if($formulario->isValid())
        {


            //Crear la entidad pago trabajador e insertarla
            $pagoTrabjador = new Entity\PagoTrabajador();
            $pagoTrabjador->setTrabajador($trabajador);
            $pagoTrabjador->setSalario($formWeb['salario']);
            $pagoTrabjador->setFechaDePago($dateForm);

            $em->persist($pagoTrabjador);

            //Actualizar la fecha de pago del trabajador
            $em->getRepository('FrontedBundle:Trabajador')->updateFechaPago($dateForm, $formWeb['info']);

            $em->flush();

            //variables del FlashBag
            $nombreTrabajador = $trabajador->getNombre();
            $fechaString =   $formWeb['fechaDePago']['year'].'-'. $formWeb['fechaDePago']['month'].'-'. $formWeb['fechaDePago']['day'];

            $this->get('session')->getFlashBag()->add('pagoIndividual',
                '¡Has pagado al trabajador: '.$nombreTrabajador .' un salario de $'.$formWeb['salario'].' el día: '.$fechaString.'! ');


            return $this->redirect($this->generateUrl('pago_trabajador'));
        }



        //Las variables necesarias en la plantilla, no se incluyen en la logica del metodo.
        $allTrabajador = $em->getRepository('FrontedBundle:Trabajador')->findall();
        $data = array('fechaDePago'=>new \DateTime('now'),
            'salario'=>$trabajador->getCargo()->getSalario(),

        );

        $form = $this->createForm(new Form\PagoIndividualTrabajadorType(), $data, array(
            'action' => $this->generateUrl('pago_trabajador_individual_save'),
            'method' => 'POST'));
        //FIN VARIABLE NECESARIAS


        return $this->render('FrontedBundle:PagosTrabajador:pagoIndividual.html.twig',
            array('entityTrabajador'=>$trabajador,
                'entities'=>$allTrabajador,
                'form'=>$form->createView(),
            )
        );

    }

    /*
     * Hacer el pago de todos los trabajadores
     */
    public function colectivoAction()
    {
        $em = $this->getDoctrine()->getManager();


        $totalTrabajador =  $em->getRepository('FrontedBundle:Trabajador')->findAll();

        //si no hay trabajadores redireccionar a la misma pagina
        if (!$totalTrabajador) {
            return $this->redirect($this->generateUrl('pago_trabajador'));
        }

        foreach($totalTrabajador as $totalTrabajador1)
        {
            $entityPagoTrabajador = new Entity\PagoTrabajador();
            //buscando el salario del trabajador
            $idCargo = $totalTrabajador1->getCargo()->getId();
            $cargo = $em->getRepository('FrontedBundle:Cargo')->find($idCargo);

            $entityPagoTrabajador->setSalario($cargo->getSalario());
            $entityPagoTrabajador->setFechaDePago(new \DateTime('today 12:00:00'));
            $entityPagoTrabajador->setTrabajador($totalTrabajador1);

            //Actualizar la fecha de pago del trabajador
            $em->getRepository('FrontedBundle:Trabajador')->updateFechaPago(new \DateTime('today'), $totalTrabajador1->getId());

            $em->persist($entityPagoTrabajador);


        }
        $em->flush();

        $this->get('session')->getFlashBag()->add('colectivo',
            '¡Has pagado a todos los trabajadores! ');

        return $this->redirect($this->generateUrl('pago_trabajador'));


    }

    public function pagoAtrasadoAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FrontedBundle:Trabajador')->findAll();

        $data = array('date'=>new \DateTime('now - 1 month'));
        $form = $this->createForm(new Form\pagoTrabajadorAtrasadoType(), $data);

        return $this->render('FrontedBundle:PagosTrabajador:pago_atrasado.html.twig',
            array('entities'=> $entities,
            'form'=>$form->createView())
        );
    }

    /**
     * Crea un pago colectivo en una fecha determinada
     */

    public function pagoAtrasadoSaveAction(Request $peticion)
    {
        $em = $this->getDoctrine()->getManager();

        //formulario del envio de pago
        $data = array('date'=>new \DateTime('now - 1 month'));
        $form = $this->createForm(new Form\pagoTrabajadorAtrasadoType(), $data);

        $formWeb = $peticion->get('pagoTrabajadorAtrasado');
        $dateForm = new \DateTime();
        $dateForm->setDate($formWeb['date']['year'],$formWeb['date']['month'], $formWeb['date']['day']);

        //Entidad y formulario para el handler
        $formulario = $this->createForm(new Form\pagoTrabajadorAtrasadoType(), null);
        $formulario->handleRequest($peticion);


        if($formulario->isValid())
        {
            //Insertando un pago de cada trabajador en la fecha dada
            $totalTrabajador =  $em->getRepository('FrontedBundle:Trabajador')->findAll();
            //si no hay trabajadores redireccionar a la misma pagina
            if (!$totalTrabajador) {
                return $this->redirect($this->generateUrl('pago_trabajador'));
            }

            foreach($totalTrabajador as $totalTrabajador1)
            {
                $entityPagoTrabajador = new Entity\PagoTrabajador();
                //buscando el salario del trabajador
                $idCargo = $totalTrabajador1->getCargo()->getId();
                $cargo = $em->getRepository('FrontedBundle:Cargo')->find($idCargo);

                $entityPagoTrabajador->setSalario($cargo->getSalario());
                $entityPagoTrabajador->setFechaDePago($dateForm);
                $entityPagoTrabajador->setTrabajador($totalTrabajador1);

                //Actualizar la fecha de pago del trabajador
                $em->getRepository('FrontedBundle:Trabajador')->updateFechaPago($dateForm, $totalTrabajador1->getId());

                $em->persist($entityPagoTrabajador);


            }
            $em->flush();

            $this->get('session')->getFlashBag()->add('colectivo',
                '¡Has pagado a todos los trabajadores en la fecha: '.$formWeb['date']['year'].'-'.$formWeb['date']['month'].'-'. $formWeb['date']['day'].'! ');

            return $this->redirect($this->generateUrl('pago_trabajador_atrasado'));
        }


        $entities = $em->getRepository('FrontedBundle:Trabajador')->findAll();
        return $this->render('FrontedBundle:PagosTrabajador:pago_atrasado.html.twig',
            array('entities'=> $entities,
                'form'=>$form->createView()
            ));

    }

   }
