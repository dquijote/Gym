<?php

namespace Gatorno\FrontedBundle\Controller;

use Gatorno\FrontedBundle\Entity\Cliente;
use Gatorno\FrontedBundle\Entity\Pago;
use Gatorno\FrontedBundle\Entity\Tarea;
use Gatorno\FrontedBundle\Entity\Visita;
use Gatorno\FrontedBundle\Form\PagosClientesType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Gatorno\FrontedBundle\Form\Front;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Security\Core\SecurityContext;

class PagosClientesController extends Controller
{

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entityPgo = new Pago();
        $entityPgo->setFechaDePago(new \DateTime('yesterday'));
        $formulario = $this->createForm(new PagosClientesType(), $entityPgo);

        //mostrando los pagos del dia
        $entityClientePago = $em->getRepository('FrontedBundle:Pago')->findCantPagosHoy(new \DateTime('today 00:00:00'), new \DateTime('today 23:57:00'));

        //Buscando y Guardando los clientes en un array
        $clientePagoArray = array();
        $cont = 0;
        foreach($entityClientePago as $entityClientePago1)
        {
            $clientePagoArray[$cont] = $em->getRepository('FrontedBundle:Cliente')->findOneBy(array('id'=>$entityClientePago1->getCliente()->getId()));
            $cont++;
        }
        return $this->render('FrontedBundle:PagosClientes:pagosClientes.html.twig',array(
            'clienteAdelantado'=>$clientePagoArray,
            'formulario'=>$formulario->createView(),
            'entityClientePago'=>$entityClientePago,
        ));

    }

    public function buscarFechaAction(Request $peticion)
    {
        $em = $this->getDoctrine()->getManager();

        $entityPgo = new Pago();
        //$entityPgo->setFechaDePago(new \DateTime('yesterday'));
        $formulario = $this->createForm(new PagosClientesType(), $entityPgo);
        $formulario->handleRequest($peticion);

        //array para almacenar los clientes que pagaron
        $clientePagoArray = array();

        if($formulario->isValid())
        {
            $entityClientePago = $em->getRepository('FrontedBundle:Pago')->findCantPagosHoy($formulario->get('fechaDePago')->getData(), $formulario->get('fechaDePago')->getData());

            //Buscando y Guardando los clientes en un array

            $cont = 0;
            foreach($entityClientePago as $entityClientePago1)
            {
                $clientePagoArray[$cont] = $em->getRepository('FrontedBundle:Cliente')->findOneBy(array('id'=>$entityClientePago1->getCliente()->getId()));
                $cont++;
            }
            $fecha = $formulario->get('fechaDePago')->getData();

            //else
            //$fecha = new \DateTime('now');



            return $this->render('FrontedBundle:PagosClientes:pagosClientes.html.twig',array(
                'clienteAdelantado'=>$clientePagoArray,
                'formulario'=>$formulario->createView(),
                'entityClientePago'=>$entityClientePago,
                'Fecha'=>$fecha,
            ));
        }
        return $this->render('FrontedBundle:PagosClientes:pagosClientes.html.twig',array(
            'clienteAdelantado'=>$clientePagoArray,
            'formulario'=>$formulario->createView(),
            //'entityClientePago'=>$entityClientePago,
        ));
    }

}
