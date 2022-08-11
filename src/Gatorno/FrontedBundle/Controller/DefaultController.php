<?php

namespace Gatorno\FrontedBundle\Controller;

use Gatorno\FrontedBundle\Entity\Cliente;
use Gatorno\FrontedBundle\Entity\Pago;
use Gatorno\FrontedBundle\Entity\Tarea;
use Gatorno\FrontedBundle\Entity\Visita;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Gatorno\FrontedBundle\Form\Front;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Security\Core\SecurityContext;

class DefaultController extends Controller
{
    public function redirecAction()
    {

        if ($this->get('security.context')->isGranted('ROLE_USUARIO'))
        {
            return $this->redirect($this->generateUrl('fronted_public'));
        }
        if ($this->get('security.context')->isGranted('ROLE_ADMIN'))
        {
            return $this->redirect($this->generateUrl('fronted_homepage'));
        }
        if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_ANONYMOUSLY'))
        {
            return $this->redirect($this->generateUrl('fronted_login'));
        }
    }


    public function loginAction(Request $peticion)
    {
        $sesion = $peticion->getSession();
        // obtener, si existe, el error producido en el último intento de login
        if ($peticion->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $peticion->attributes->get(
                SecurityContext::AUTHENTICATION_ERROR
            );
        } else {
            $error = $sesion->get(SecurityContext::AUTHENTICATION_ERROR);
            $sesion->remove(SecurityContext::AUTHENTICATION_ERROR);
        }
        return $this->render('FrontedBundle:Default:login.html.twig', array(
            'last_username' => $sesion->get(SecurityContext::LAST_USERNAME),
            'error' => $error
        ));
    }



    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        //cliente
        $clientes = $em->getRepository('FrontedBundle:Cliente')->findAll();
        $cantClientes = count($clientes);

        //Cuantos visitantes han tenido en el dia
        $visitantesDelDia = $em->getRepository('FrontedBundle:Visita')->findCantVisitantes(new \DateTime('today'),new \DateTime('tomorrow'));
        if($visitantesDelDia)
            $cantVisitantesDia = count($visitantesDelDia);
        else
            $cantVisitantesDia = 0;

        //Cuantos visitantes han tenido en el mes
        $visitantesDelMes = $em->getRepository('FrontedBundle:Visita')->findCantVisitantes(new \DateTime('first day of 00:00:00'),new \DateTime('last day of 23:59:00'));
        $cantVisitantesDelMes = count($visitantesDelMes);

        //Los nuevos clientes por mes
        $nuevoClienteEne = count($em->getRepository('FrontedBundle:Cliente')->findFiltroFecha(new \DateTime('first day of jan ' ), new \DateTime('last day of jan 23:50:00')));
        $nuevoClienteFeb = count($em->getRepository('FrontedBundle:Cliente')->findFiltroFecha(new \DateTime('first day of feb ' ), new \DateTime('last day of feb 23:50:00')));
        $nuevoClienteMar = count($em->getRepository('FrontedBundle:Cliente')->findFiltroFecha(new \DateTime('first day of mar ' ), new \DateTime('last day of mar 23:50:00')));
        $nuevoClienteAbr = count($em->getRepository('FrontedBundle:Cliente')->findFiltroFecha(new \DateTime('first day of apr ' ), new \DateTime('last day of apr 23:50:00')));
        $nuevoClienteMay = count($em->getRepository('FrontedBundle:Cliente')->findFiltroFecha(new \DateTime('first day of may ' ), new \DateTime('last day of may 23:50:00')));
        $nuevoClienteJun = count($em->getRepository('FrontedBundle:Cliente')->findFiltroFecha(new \DateTime('first day of jun ' ), new \DateTime('last day of jun 23:59:00')));
        $nuevoClienteJul = count($em->getRepository('FrontedBundle:Cliente')->findFiltroFecha(new \DateTime('first day of jul ' ), new \DateTime('last day of jul 23:59:00')));
        $nuevoClienteAgo = count($em->getRepository('FrontedBundle:Cliente')->findFiltroFecha(new \DateTime('first day of aug ' ), new \DateTime('last day of aug 23:59:00')));
        $nuevoClienteSep = count($em->getRepository('FrontedBundle:Cliente')->findFiltroFecha(new \DateTime('first day of sep ' ), new \DateTime('last day of sep 23:59:00')));
        $nuevoClienteOct = count($em->getRepository('FrontedBundle:Cliente')->findFiltroFecha(new \DateTime('first day of oct ' ), new \DateTime('last day of oct 23:59:00')));
        $nuevoClienteNov = count($em->getRepository('FrontedBundle:Cliente')->findFiltroFecha(new \DateTime('first day of nov ' ), new \DateTime('last day of nov 23:59:00')));
        $nuevoClienteDic = count($em->getRepository('FrontedBundle:Cliente')->findFiltroFecha(new \DateTime('first day of dec ' ), new \DateTime('last day of dec 23:59:00')));

        //var_dump(new \DateTime('tomorrow 23:00:00'));
        //var_dump(new \DateTime('last day of 23:00:00'));
        //var_dump(new \DateTime('first day of mar 01:00:00'));
        //var_dump($em->getRepository('FrontedBundle:Cliente')->findFiltroFecha(new \DateTime('first day of apr ' ), new \DateTime('last day of apr 23:59:00')));
        //var_dump($em->getRepository('FrontedBundle:Cliente')->findFiltroFecha(new \DateTime('first day of mar 00:00:00' ), new \DateTime('last day of mar 23:59:00')));

        //Ingresos monetario mensuales
        /*
         * tomar todos los pagos del mes, revisar que tipo de cliente pago y multiplicar el valor
         */
        $pagosClientesMes  = $em->getRepository('FrontedBundle:Pago')->findCantPagosHoy(new \DateTime('first day of 00:00:00' ),new \DateTime('last day of 23:59:00' ));
        $sumatoriaPagosMes = 0;

        //$pruebaMostrarFecha =  $em->getRepository('FrontedBundle:Pago')->find(5987);first day of 01:00:00
        //var_dump(new \DateTime('first day of 00:00:00'));

        //if($pagosClientesMes)
        foreach($pagosClientesMes as $pagosClientesMes1)
        {
            foreach($clientes as $cliente1)
            {
                if($pagosClientesMes1->getCliente()->getId() == $cliente1->getId())
                $sumatoriaPagosMes = $cliente1->getCostoDeServicio() + $sumatoriaPagosMes;
            }


        }


        //Clientes que tienen que pagar este mes.
        $sumatoriaPagosMesDeberian = 0;
        $clientesQueDebenPagarMes = $em->getRepository('FrontedBundle:Cliente')->findFechaDePago(new \DateTime('first day of 01:00:00' ),new \DateTime('last day of 23:00:00' ));
        foreach($clientesQueDebenPagarMes as $clientesQueDebenPagarMes1)
        {
            $sumatoriaPagosMesDeberian = $clientesQueDebenPagarMes1->getCostoDeServicio() + $sumatoriaPagosMesDeberian;
        }

        //Saber cuantos clientes se incorporaron este mes
        $nuevoClienteMes = count($em->getRepository('FrontedBundle:Cliente')->findFiltroFecha(new \DateTime('first day of 00:00:00' ), new \DateTime('last day of 23:00:00')));

        //$datePrueba =  new \DateTime('first day of' );
        //var_dump($nuevoClienteMes);
        //$datePruebaLast = new \DateTime('last day of');
       // var_dump($sumatoriaPagosMesDeberian);

        //cantidad de pagos en el dia
        $cantPagoDelDia = $em->getRepository('FrontedBundle:Pago')->findCantPagosHoy(new \DateTime('today '),new \DateTime('today 23:55:00'));
        if($cantPagoDelDia)
            $cantPagoDia = count($cantPagoDelDia);
        else
            $cantPagoDia = 0;


        //TIPOS DE CLIENTES
        //Muestra solo los 2 tipos de clientes con mayor importe a pagar
        $tiposClientes2 = $em->getRepository('FrontedBundle:TipoCliente')->findBy(array(),array('importe' => 'DESC'),2);
        $tiposClientes = $em->getRepository('FrontedBundle:TipoCliente')->findAll();

        //Add up all the money to cliente pay in the day
        $moneyToday = 0;
        if($cantPagoDelDia)
            foreach($cantPagoDelDia as $var)
            {
               $clienteTemp = $em->getRepository('FrontedBundle:Cliente')->find($var->getCliente());
                $moneyToday = $moneyToday + $clienteTemp->getCostoDeservicio();
            }

        $tiposClientesMayorImporte = 0;
        $tiposClientesMayorImporte2 = 0;
        $countClientesMayorImporte = 0;
        $countClientesMayorImporte2 = 0;
//var_dump($tiposClientes2);
        foreach($cantPagoDelDia as $pagosDelDia)
        {
            if($pagosDelDia->getCliente()->getTipo() == $tiposClientes2[0]->getTipo())
            {
                $tiposClientesMayorImporte = $tiposClientesMayorImporte + $pagosDelDia->getCliente()->getCostoDeservicio();
                $countClientesMayorImporte++;

            }

            if($pagosDelDia->getCliente()->getTipo() == $tiposClientes2[1]->getTipo())
            {
                $tiposClientesMayorImporte2 = $tiposClientesMayorImporte2 + $pagosDelDia->getCliente()->getCostoDeservicio();
                $countClientesMayorImporte2++;

            }

        }

//
//var_dump($moneyToday);
//var_dump($tiposClientesMayorImporte);
//var_dump($tiposClientesMayorImporte2);

        //contar la cant de pagos VIP, mitad de precio, full.
        $VIP = 0;
        $MP = 0;
        $Full =0;
        if($cantPagoDelDia)
        foreach($cantPagoDelDia as $var)
        {
            foreach($clientes as $cliente)
            {
                if($cliente == $var->getCliente())
                {
                    if($cliente->getTipo() == 'VIP')
                        $VIP = $VIP + 1;
                    if($cliente->getTipo() == 'MP')
                        $MP = $MP + 1;
                    if($cliente->getTipo() == 'Full')
                        $Full = $Full + 1;
                }
            }
        }


        //Buscar los clientes que pagaron hoy
        $cont = 0;
        $clientesPagoHoy = array();
        if($cantPagoDelDia)
            foreach($cantPagoDelDia as $pago)
            {

                $clientesPagoHoy[$cont] = $em->getRepository('FrontedBundle:Cliente')->findOneBy(array('id'=>$pago->getCliente())) ;
                $cont++;
            }
        //nuevo del joven club
        //clientes activos
        $clientesActivos = $em->getRepository('FrontedBundle:Cliente')->findFechaDePago(new \DateTime('first day of 01:00:00' ),new \DateTime('last day of next month  23:00:00' ));
        $cantClientesActivos =  count($clientesActivos);



        //********************************************************************************************
        //GASTOS
        $gastos = $this->Gastos();//'anualPagoTrabajador'=>$anualPagoTrabajador, 'anualGastoVariado'=>$anualGastoVariado,

        //var_dump($gastos);

        //CLIENTES ACTIVOS POR MES,AUN CON LOS VALORES REPETIDOS.
        $clienteRepetidoEne = $this->pago_id_cliente($em->getRepository('FrontedBundle:Pago')->findCantPagosHoy(new \DateTime('first day of jan ' ), new \DateTime('last day of jan '))) ;
        $clienteRepetidoFeb = $this->pago_id_cliente($em->getRepository('FrontedBundle:Pago')->findCantPagosHoy(new \DateTime('first day of feb ' ), new \DateTime('last day of feb '))) ;
        $clienteRepetidoMar = $this->pago_id_cliente($em->getRepository('FrontedBundle:Pago')->findCantPagosHoy(new \DateTime('first day of mar ' ), new \DateTime('last day of mar '))) ;
        $clienteRepetidoAbr = $this->pago_id_cliente($em->getRepository('FrontedBundle:Pago')->findCantPagosHoy(new \DateTime('first day of apr ' ), new \DateTime('last day of apr '))) ;
        $clienteRepetidoMay = $this->pago_id_cliente($em->getRepository('FrontedBundle:Pago')->findCantPagosHoy(new \DateTime('first day of may ' ), new \DateTime('last day of may '))) ;
        $clienteRepetidoJun = $this->pago_id_cliente($em->getRepository('FrontedBundle:Pago')->findCantPagosHoy(new \DateTime('first day of jun ' ), new \DateTime('last day of jun '))) ;
        $clienteRepetidoJul = $this->pago_id_cliente($em->getRepository('FrontedBundle:Pago')->findCantPagosHoy(new \DateTime('first day of jul ' ), new \DateTime('last day of jul '))) ;
        $clienteRepetidoAgo = $this->pago_id_cliente($em->getRepository('FrontedBundle:Pago')->findCantPagosHoy(new \DateTime('first day of aug ' ), new \DateTime('last day of aug '))) ;
        $clienteRepetidoSep = $this->pago_id_cliente($em->getRepository('FrontedBundle:Pago')->findCantPagosHoy(new \DateTime('first day of sep ' ), new \DateTime('last day of sep '))) ;
        $clienteRepetidoOct = $this->pago_id_cliente($em->getRepository('FrontedBundle:Pago')->findCantPagosHoy(new \DateTime('first day of oct ' ), new \DateTime('last day of oct '))) ;
        $clienteRepetidoNov = $this->pago_id_cliente($em->getRepository('FrontedBundle:Pago')->findCantPagosHoy(new \DateTime('first day of nov ' ), new \DateTime('last day of nov '))) ;
        $clienteRepetidoDic = $this->pago_id_cliente($em->getRepository('FrontedBundle:Pago')->findCantPagosHoy(new \DateTime('first day of dec ' ), new \DateTime('last day of dec '))) ;

        //var_dump(count($clienteRepetidoFeb));
        //var_dump(count($clienteRepetidoMar));
        //valores repetidos por meses
        $valorRepetidoEnero = $this->valor_repetidos_array($clienteRepetidoEne);
        $valorRepetidoFebrero = $this->valor_repetidos_array($clienteRepetidoFeb);
        $valorRepetidoMarzo = $this->valor_repetidos_array($clienteRepetidoMar);
        $valorRepetidoAbril = $this->valor_repetidos_array($clienteRepetidoAbr);
        $valorRepetidoMayo = $this->valor_repetidos_array($clienteRepetidoMay);
        $valorRepetidoJunio = $this->valor_repetidos_array($clienteRepetidoJun);
        $valorRepetidoJulio = $this->valor_repetidos_array($clienteRepetidoJul);
        $valorRepetidoAgosto = $this->valor_repetidos_array($clienteRepetidoAgo);
        $valorRepetidoSeptiembre = $this->valor_repetidos_array($clienteRepetidoSep);
        $valorRepetidoOctubre = $this->valor_repetidos_array($clienteRepetidoOct);
        $valorRepetidoNoviembre = $this->valor_repetidos_array($clienteRepetidoNov);
        $valorRepetidoDicimebre = $this->valor_repetidos_array($clienteRepetidoDic);

        //var_dump($valorRepetidoFebrero);

        $cant_clientes_activos_enero = 0;
        $cant_clientes_activos_febrero = 0;
        $cant_clientes_activos_marzo = 0;
        $cant_clientes_activos_abril = 0;
        $cant_clientes_activos_mayo = 0;
        $cant_clientes_activos_junio = 0;
        $cant_clientes_activos_julio = 0;
        $cant_clientes_activos_agosto = 0;
        $cant_clientes_activos_septiembre = 0;
        $cant_clientes_activos_octubre = 0;
        $cant_clientes_activos_noviembre = 0;
        $cant_clientes_activos_diciembre = 0;


        foreach ($valorRepetidoEnero as $a) {
            while($a > 0)
            {
                $cant_clientes_activos_febrero = $cant_clientes_activos_febrero + 1;
                $a--;
                if($a>0)
                {
                    $cant_clientes_activos_marzo = $cant_clientes_activos_marzo + 1;
                    $a--;
                }

                if($a>0)
                {
                    $cant_clientes_activos_abril = $cant_clientes_activos_abril + 1;
                    $a--;
                }
                if($a>0)
                {
                    $cant_clientes_activos_mayo = $cant_clientes_activos_mayo + 1;
                    $a--;
                }
                if($a>0)
                {
                    $cant_clientes_activos_junio = $cant_clientes_activos_junio + 1;
                    $a--;
                }
                if($a>0)
                {
                    $cant_clientes_activos_julio = $cant_clientes_activos_julio + 1;
                    $a--;
                }
                if($a>0)
                {
                    $cant_clientes_activos_agosto = $cant_clientes_activos_agosto + 1;
                    $a--;
                }
                if($a>0)
                {
                    $cant_clientes_activos_septiembre = $cant_clientes_activos_septiembre + 1;
                    $a--;
                }
                if($a>0)
                {
                    $cant_clientes_activos_octubre = $cant_clientes_activos_octubre + 1;
                    $a--;
                }
                if($a>0)
                {
                    $cant_clientes_activos_noviembre = $cant_clientes_activos_noviembre + 1;
                    $a--;
                }
                if($a>0)
                {
                    $cant_clientes_activos_diciembre = $cant_clientes_activos_diciembre + 1;
                    $a--;
                }
            }
        }

        foreach ($valorRepetidoFebrero as $a) {
            while($a > 0)
            {
                $cant_clientes_activos_marzo = $cant_clientes_activos_marzo + 1;
                $a--;

                if($a>0)
                {
                    $cant_clientes_activos_abril = $cant_clientes_activos_abril + 1;
                    $a--;
                }
                if($a>0)
                {
                    $cant_clientes_activos_mayo = $cant_clientes_activos_mayo + 1;
                    $a--;
                }
                if($a>0)
                {
                    $cant_clientes_activos_junio = $cant_clientes_activos_junio + 1;
                    $a--;
                }

                if($a>0)
                {
                    $cant_clientes_activos_julio = $cant_clientes_activos_julio + 1;
                    $a--;
                }
                if($a>0)
                {
                    $cant_clientes_activos_agosto = $cant_clientes_activos_agosto + 1;
                    $a--;
                }
                if($a>0)
                {
                    $cant_clientes_activos_septiembre = $cant_clientes_activos_septiembre + 1;
                    $a--;
                }
                if($a>0)
                {
                    $cant_clientes_activos_octubre = $cant_clientes_activos_octubre + 1;
                    $a--;
                }
                if($a>0)
                {
                    $cant_clientes_activos_noviembre = $cant_clientes_activos_noviembre + 1;
                    $a--;
                }
                if($a>0)
                {
                    $cant_clientes_activos_diciembre = $cant_clientes_activos_diciembre + 1;
                    $a--;
                }
            }
        }

        foreach ($valorRepetidoMarzo as $a) {
            while($a > 0)
            {
                $cant_clientes_activos_abril = $cant_clientes_activos_abril + 1;
                $a--;

                if($a>0)
                {
                    $cant_clientes_activos_mayo = $cant_clientes_activos_mayo + 1;
                    $a--;
                }
                if($a>0)
                {
                    $cant_clientes_activos_junio = $cant_clientes_activos_junio + 1;
                    $a--;
                }
                if($a>0)
                {
                    $cant_clientes_activos_julio = $cant_clientes_activos_julio + 1;
                    $a--;
                }
                if($a>0)
                {
                    $cant_clientes_activos_agosto = $cant_clientes_activos_agosto + 1;
                    $a--;
                }
                if($a>0)
                {
                    $cant_clientes_activos_septiembre = $cant_clientes_activos_septiembre + 1;
                    $a--;
                }
                if($a>0)
                {
                    $cant_clientes_activos_octubre = $cant_clientes_activos_octubre + 1;
                    $a--;
                }
                if($a>0)
                {
                    $cant_clientes_activos_noviembre = $cant_clientes_activos_noviembre + 1;
                    $a--;
                }
                if($a>0)
                {
                    $cant_clientes_activos_diciembre = $cant_clientes_activos_diciembre + 1;
                    $a--;
                }
            }
        }

        foreach ($valorRepetidoAbril as $a) {
            while($a > 0)
            {
                $cant_clientes_activos_mayo = $cant_clientes_activos_mayo + 1;
                $a--;

                if($a>0)
                {
                    $cant_clientes_activos_junio = $cant_clientes_activos_junio + 1;
                    $a--;
                }
                if($a>0)
                {
                    $cant_clientes_activos_julio = $cant_clientes_activos_julio + 1;
                    $a--;
                }
                if($a>0)
                {
                    $cant_clientes_activos_agosto = $cant_clientes_activos_agosto + 1;
                    $a--;
                }
                if($a>0)
                {
                    $cant_clientes_activos_septiembre = $cant_clientes_activos_septiembre + 1;
                    $a--;
                }
                if($a>0)
                {
                    $cant_clientes_activos_octubre = $cant_clientes_activos_octubre + 1;
                    $a--;
                }
                if($a>0)
                {
                    $cant_clientes_activos_noviembre = $cant_clientes_activos_noviembre + 1;
                    $a--;
                }
                if($a>0)
                {
                    $cant_clientes_activos_diciembre = $cant_clientes_activos_diciembre + 1;
                    $a--;
                }
            }
        }

        foreach ($valorRepetidoMayo as $a) {
            while($a > 0)
            {
                    $cant_clientes_activos_junio = $cant_clientes_activos_junio + 1;
                    $a--;

                if($a>0)
                {
                    $cant_clientes_activos_julio = $cant_clientes_activos_julio + 1;
                    $a--;
                }
                if($a>0)
                {
                    $cant_clientes_activos_agosto = $cant_clientes_activos_agosto + 1;
                    $a--;
                }
                if($a>0)
                {
                    $cant_clientes_activos_septiembre = $cant_clientes_activos_septiembre + 1;
                    $a--;
                }
                if($a>0)
                {
                    $cant_clientes_activos_octubre = $cant_clientes_activos_octubre + 1;
                    $a--;
                }
                if($a>0)
                {
                    $cant_clientes_activos_noviembre = $cant_clientes_activos_noviembre + 1;
                    $a--;
                }
                if($a>0)
                {
                    $cant_clientes_activos_diciembre = $cant_clientes_activos_diciembre + 1;
                    $a--;
                }
            }
        }

        foreach ($valorRepetidoJunio as $a) {
            while($a > 0)
            {
                $cant_clientes_activos_julio = $cant_clientes_activos_julio + 1;
                $a--;

                if($a>0)
                {
                    $cant_clientes_activos_agosto = $cant_clientes_activos_agosto + 1;
                    $a--;
                }
                if($a>0)
                {
                    $cant_clientes_activos_septiembre = $cant_clientes_activos_septiembre + 1;
                    $a--;
                }
                if($a>0)
                {
                    $cant_clientes_activos_octubre = $cant_clientes_activos_octubre + 1;
                    $a--;
                }
                if($a>0)
                {
                    $cant_clientes_activos_noviembre = $cant_clientes_activos_noviembre + 1;
                    $a--;
                }
                if($a>0)
                {
                    $cant_clientes_activos_diciembre = $cant_clientes_activos_diciembre + 1;
                    $a--;
                }
            }
        }

        foreach ($valorRepetidoJulio as $a) {
            while($a > 0)
            {
                $cant_clientes_activos_agosto = $cant_clientes_activos_agosto + 1;
                $a--;

                if($a>0)
                {
                    $cant_clientes_activos_septiembre = $cant_clientes_activos_septiembre + 1;
                    $a--;
                }
                if($a>0)
                {
                    $cant_clientes_activos_octubre = $cant_clientes_activos_octubre + 1;
                    $a--;
                }
                if($a>0)
                {
                    $cant_clientes_activos_noviembre = $cant_clientes_activos_noviembre + 1;
                    $a--;
                }
                if($a>0)
                {
                    $cant_clientes_activos_diciembre = $cant_clientes_activos_diciembre + 1;
                    $a--;
                }
            }
        }

        foreach ($valorRepetidoAgosto as $a) {
            while($a > 0)
            {
                $cant_clientes_activos_septiembre = $cant_clientes_activos_septiembre + 1;
                $a--;

                if($a>0)
                {
                    $cant_clientes_activos_octubre = $cant_clientes_activos_octubre + 1;
                    $a--;
                }
                if($a>0)
                {
                    $cant_clientes_activos_noviembre = $cant_clientes_activos_noviembre + 1;
                    $a--;
                }
                if($a>0)
                {
                    $cant_clientes_activos_diciembre = $cant_clientes_activos_diciembre + 1;
                    $a--;
                }
            }
        }

        foreach ($valorRepetidoSeptiembre as $a) {
            while($a > 0)
            {
                $cant_clientes_activos_octubre = $cant_clientes_activos_octubre + 1;
                $a--;

                if($a>0)
                {
                    $cant_clientes_activos_noviembre = $cant_clientes_activos_noviembre + 1;
                    $a--;
                }
                if($a>0)
                {
                    $cant_clientes_activos_diciembre = $cant_clientes_activos_diciembre + 1;
                    $a--;
                }
            }
        }

        foreach ($valorRepetidoOctubre as $a) {
            while($a > 0)
            {
                $cant_clientes_activos_noviembre = $cant_clientes_activos_noviembre + 1;
                $a--;

                if($a>0)
                {
                    $cant_clientes_activos_diciembre = $cant_clientes_activos_diciembre + 1;
                    $a--;
                }
            }
        }

        foreach ($valorRepetidoNoviembre as $a) {
            while($a > 0)
            {
                $cant_clientes_activos_diciembre = $cant_clientes_activos_diciembre + 1;
                $a--;

            }
        }

        $cant_clientes_activos_enero = count(array_unique($clienteRepetidoEne));
        $cant_clientes_activos_febrero = $cant_clientes_activos_febrero + count(array_unique($clienteRepetidoFeb));
        $cant_clientes_activos_marzo = $cant_clientes_activos_marzo + count(array_unique($clienteRepetidoMar));
        $cant_clientes_activos_abril = $cant_clientes_activos_abril + count(array_unique($clienteRepetidoAbr));
        $cant_clientes_activos_mayo = $cant_clientes_activos_mayo + count(array_unique($clienteRepetidoMay));
        $cant_clientes_activos_junio = $cant_clientes_activos_junio + count(array_unique($clienteRepetidoJun));
        $cant_clientes_activos_julio = $cant_clientes_activos_julio + count(array_unique($clienteRepetidoJul));
        $cant_clientes_activos_agosto = $cant_clientes_activos_agosto + count(array_unique($clienteRepetidoAgo));
        $cant_clientes_activos_septiembre = $cant_clientes_activos_septiembre + count(array_unique($clienteRepetidoSep));
        $cant_clientes_activos_octubre = $cant_clientes_activos_octubre + count(array_unique($clienteRepetidoOct));
        $cant_clientes_activos_noviembre = $cant_clientes_activos_noviembre + count(array_unique($clienteRepetidoNov));
        $cant_clientes_activos_diciembre = $cant_clientes_activos_diciembre+ count(array_unique($clienteRepetidoDic));


//var_dump(new \DateTime('first day of jan'));
//var_dump(new \DateTime('first day of feb'));
//var_dump(new \DateTime('first day of mar'));
//var_dump(new \DateTime('first day of apr'));
//var_dump(new \DateTime('first day of may'));
//var_dump(new \DateTime('first day of jun'));
//var_dump(new \DateTime('first day of jul'));
//var_dump(new \DateTime('first day of aug'));
//var_dump(new \DateTime('first day of sep'));
//var_dump(new \DateTime('first day of oct'));
//var_dump(new \DateTime('first day of nov'));
//var_dump(new \DateTime('first day of dec'));


        return $this->render('FrontedBundle:Default:index.html.twig',
        array(
            'cantVisitantesDia'=>$cantVisitantesDia,
            'cantPagoDia'=>$cantPagoDia,
            'moneyToday'=>$moneyToday,
            'tiposClientesMayorImporte'=>$tiposClientesMayorImporte,
            'tiposClientesMayorImporte2'=>$tiposClientesMayorImporte2,
            'countClientesMayorImporte'=> $countClientesMayorImporte,
            'countClientesMayorImporte2'=> $countClientesMayorImporte2,
            'clientesPagoHoy'=>$clientesPagoHoy,
            'tiposClientes2'=>$tiposClientes2,

            'nuevoClienteEne'=>$nuevoClienteEne,
            'nuevoClienteFeb'=>$nuevoClienteFeb,
            'nuevoClienteMar'=>$nuevoClienteMar,
            'nuevoClienteAbr'=>$nuevoClienteAbr,
            'nuevoClienteMay'=>$nuevoClienteMay,
            'nuevoClienteJun'=>$nuevoClienteJun,
            'nuevoClienteJul'=>$nuevoClienteJul,
            'nuevoClienteAgo'=>$nuevoClienteAgo,
            'nuevoClienteSep'=>$nuevoClienteSep,
            'nuevoClienteOct'=>$nuevoClienteOct,
            'nuevoClienteNov'=>$nuevoClienteNov,
            'nuevoClienteDic'=>$nuevoClienteDic,

            'sumatoriaPagosMes'=>$sumatoriaPagosMes,
            'sumatoriaPagosMesDeberian'=>$sumatoriaPagosMesDeberian,

            'nuevoClienteMes'=>$nuevoClienteMes,
            'cantClientes'=>$cantClientes,

            'cantVisitantesDelMes'=>$cantVisitantesDelMes,
            'clientesActivos'=>$cantClientesActivos,

            'anualPagoTrabajador'=>$gastos['anualPagoTrabajador'],
            'anualGastoVariado'=>$gastos['anualGastoVariado'],
            'gastos'=>$gastos,


            'cant_clientes_activos_enero' =>$cant_clientes_activos_enero,
            'cant_clientes_activos_febrero'=> $cant_clientes_activos_febrero,
            'cant_clientes_activos_marzo' => $cant_clientes_activos_marzo,
            'cant_clientes_activos_abril' => $cant_clientes_activos_abril,
            'cant_clientes_activos_mayo' => $cant_clientes_activos_mayo,
            'cant_clientes_activos_junio' => $cant_clientes_activos_junio,
            'cant_clientes_activos_julio' => $cant_clientes_activos_julio,
            'cant_clientes_activos_agosto' => $cant_clientes_activos_agosto,
            'cant_clientes_activos_septiembre' => $cant_clientes_activos_septiembre,
            'cant_clientes_activos_octubre' => $cant_clientes_activos_octubre,
            'cant_clientes_activos_noviembre' => $cant_clientes_activos_noviembre,
            'cant_clientes_activos_diciembre' => $cant_clientes_activos_diciembre,
        )
        );
    }
    public function loginFullAction()
    {
        $formulario = $this->createForm(new Front\BuscarClienteType());
        //$formulario = $this-> BuscarClienteType();
        $noEncontrado = false;
        return $this->render('FrontedBundle:Default:login-full.html.twig',array(
            'formulario'=>$formulario->createView(),
            'noEncontrado'=>$noEncontrado,
        ));
    }

    public function pagarClienteAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $clientePaga = $em->getRepository('FrontedBundle:Cliente')->findOneBy(array('id'=>$id));

        $intervalo = new \DateInterval($this->periodoCobro('m'));
        $time = $clientePaga->getFechaDePago();
        $time->add($intervalo);

        //Actualizando la fecha de pago del cliente
       // $clientePaga->setFechaDePago($time);
        $em->getRepository('FrontedBundle:Cliente')->findUpdateFechaDePago($id, $time);

       // $em->persist($clientePaga);
        $em->flush();

        //registrando el pago del cliente
        $entityPago = new Pago();
        $entityPago->setFechaDePago(new \DateTime('now'));
        $entityPago->setCliente($clientePaga);
        $entityPago->setPagado(true);

       $em->persist($entityPago);
       $em->flush();

        $clienteBuscado = $em->getRepository('FrontedBundle:Cliente')->find($id);

        $this->get('session')->getFlashBag()->add('pagado',
            '¡Pago satisfactorio! ');
        $var = 2;//Para mostrar el FlashBag y repetir el formulario con los datos del cliente


        $formulario = $this->createForm(new Front\BuscarClienteType());
        //$formulario = $this-> BuscarClienteType();
        $noEncontrado = false;
        return $this->render('FrontedBundle:Default:login-full.html.twig',array(
            'formulario'=>$formulario->createView(),
            'noEncontrado'=>$noEncontrado,
            'var'=>$var,
            'clienteBuscado'=>$clienteBuscado,
        ));
    }


    public function cambiarFechaPagoClienteAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        $cliente = $em->getRepository('FrontedBundle:Cliente')->findOneBy(array('id'=>$id));
        $cliente->setFechaDeIngreso(new \DateTime());
        $cliente->setFechaDePago(new \DateTime());

        $formulario = $this->createForm(new Front\ClienteFechaPagoType(),$cliente);
        //$formulario = $this-> BuscarClienteType();
        return $this->render('FrontedBundle:Default:cambiarFechaPago.html.twig',array(
            'formulario'=>$formulario->createView(),
            'cliente'=>$cliente,
            'id'=>$id,
        ));
    }

    public function cambiarFechaPagoClienteSaveAction(Request $peticion, $id)
    {

        $em = $this->getDoctrine()->getManager();


        //obteniendo el cliente mediante id
        $cliente = $em->getRepository('FrontedBundle:Cliente')->findOneBy(array('id'=>$id));


        $formWeb = $peticion->get('gatorno_frontedbundle_FechaPago');

        $entityCliente = new Cliente();
        $formulario = $this->createForm(new Front\ClienteFechaPagoType(),$entityCliente);
        $formulario->handleRequest($peticion);


        if($formulario->isValid())
        {

            if($cliente)
            {
                $costo = 0;

                if($formWeb['tipo'] == 'VIP')
                {
                    $costo = 0;
                }
                if($formWeb['tipo'] == 'MP')
                {
                    $costo = 3;
                }
                if($formWeb['tipo'] == 'Full')
                {
                    $costo = 6;
                }

                //$tipoCliente = $em->getRepository('FrontedBundle:TipoCliente')->findAll();
                $tipo = $em->getRepository('FrontedBundle:TipoCliente')->find($formWeb['tipo']);


                //estableciendo la fecha de pago
                $intervalo = new \DateInterval($this->periodoCobro('m'));
                $time = new \DateTime('now');
                $time->add($intervalo);


                //actualizar los datos del cliente que se reincorpora
                $servicio = 'Gym';
                $em->getRepository('FrontedBundle:Cliente')->findUpdateReincorporacion(
                    $cliente->getId(),
                    $formWeb['nombre'],
                    $formWeb['apellidos'],
                    $time,
                    $tipo->getTipo(),
                    $servicio,
                    $tipo->getImporte()
                );

                //pongo este flush aqui porque no me esta devolviendo la entidad actualizada, pero si se actualiza en la BD
                $em->flush();

                $clienteDepuesDeActualizar = $em->getRepository('FrontedBundle:Cliente')->find($id);

                //registrar el pago
                $entityPago = new Pago();
                $entityPago->setCliente($clienteDepuesDeActualizar);
                $entityPago->setFechaDePago(new \DateTime('now'));
                $entityPago->setPagado(true);


                $em->persist($entityPago);
                $em->flush();





                //registrando la visita del cliente
                $entityVisita = new Visita();
                $entityVisita->setHora(new \DateTime('now'));
                $entityVisita->setFecha(new \DateTime('now'));
                $entityVisita->setCliente($clienteDepuesDeActualizar);
                $em->persist($entityVisita);
                $em->flush();

                $clienteDepuesDeActualizar1 = $em->getRepository('FrontedBundle:Cliente')->find($id);
                $clienteDepuesDeActualizar1->setFechaDePago($time);
                $clienteDepuesDeActualizar1->setTipo($tipo->getTipo());
                $clienteDepuesDeActualizar1->setCostoDeservicio($tipo->getImporte());
                $clienteDepuesDeActualizar1->setNombre($formWeb['nombre']);
                $clienteDepuesDeActualizar1->setApellidos($formWeb['apellidos']);

                //var_dump($clienteDepuesDeActualizar1);

                //creando los datos necesarios para la vista buscar
                $formularioBuscar =  $this->createForm(new Front\BuscarClienteType()) ;
                return $this->render('FrontedBundle:Default:login-full.html.twig',array(
                    'formulario'=>$formularioBuscar->createView(),
                    'clienteBuscado'=>$clienteDepuesDeActualizar1,
                    //'noEncontrado'=>$noEncontrado,
                    //'clienteBuscadoFechaDePago'=>$clienteBuscadoFechaDePago,

                ));
            }

        }


        return $this->render('FrontedBundle:Default:cambiarFechaPago.html.twig',array(
            'formulario'=>$formulario->createView(),
            'cliente'=>$cliente,
        ));
    }

    public function buscarClienteAction(Request $peticion)
    {
        $em = $this->getDoctrine()->getManager();

        $entityCliente = new Cliente();

        $formulario = $this->createForm(new Front\BuscarClienteType(),$entityCliente);
        $formulario->handleRequest($peticion);

        $claveFromWeb = $formulario->get('clave')->getData();

        if($formulario->isValid())
        {
            $entityVisita = new Visita();//para registrarlo como una visita, en caso de que exista
            $clienteBuscado = $em->getRepository('FrontedBundle:Cliente')->findOneBy(array('clave'=>$claveFromWeb));

            if($clienteBuscado)
            {
                /*
                 * Registrar como una visita cada vez que el cliente se busque.
                 */
                $entityVisita->setCliente($clienteBuscado);
                $entityVisita->setFecha(new \DateTime('now'));
                $entityVisita->setHora(new \DateTime('now'));

                $em->persist($entityVisita);
                $em->flush();

            }


            if(!$clienteBuscado)
            {
                $this->get('session')->getFlashBag()->add('noEncontrado',
                    '¡No se encuentra registrado! ');
                $noEncontrado = true;
                //$clienteBuscadoFechaDePago = false;
            }
            else
                $noEncontrado = false;



            return $this->render('FrontedBundle:Default:login-full.html.twig',array(
                'formulario'=>$formulario->createView(),
                'clienteBuscado'=>$clienteBuscado,
                'noEncontrado'=>$noEncontrado,
                //'clienteBuscadoFechaDePago'=>$clienteBuscadoFechaDePago,

            ));
        }


        //$formulario = $this-> BuscarClienteType();
        return $this->render('FrontedBundle:Default:login-full.html.twig',array(
            'formulario'=>$formulario->createView(),
        ));
    }


    public function registrarAction()
    {
        $formulario = $this->createForm(new Front\ClienteType());
        //$formulario = $this-> BuscarClienteType();
        return $this->render('FrontedBundle:Default:registration-full.html.twig',array(
            'formulario'=>$formulario->createView(),
        ));
    }

    public function formAction()
    {
        $formulario = $this->createForm(new Front\ClienteType());
        //$formulario = $this-> BuscarClienteType();
        return $this->render('FrontedBundle:Default:form-elements.html.twig',array(
            'formulario'=>$formulario->createView(),
        ));
    }

    public function registrarSaveAction(Request $peticion)
    {
        $em = $this->getDoctrine()->getManager();

        $formWeb = $peticion->get('gatorno_frontedbundle_cliente');

        $entityCliente = new Cliente();
        $formulario = $this->createForm(new Front\ClienteType(),$entityCliente);
        $formulario->handleRequest($peticion);

        if($formulario->isValid())
        {


            $entityPago = new Pago();
           // $fechaIngreso = $formWeb['fechaDeIngreso'];
            $tipCliente = $formWeb['tipo'];
           // $fechaPago = $formWeb['fechaDePago'];

            //Buscando el pago por el tipo de cliente
            $pago = $em->getRepository('FrontedBundle:TipoCliente')->find($tipCliente)->getImporte();
            $tiposClientes = $em->getRepository('FrontedBundle:TipoCliente')->findAll();
            //var_dump($tiposClientes);
            //var_dump($tipCliente);
//            foreach ($tiposClientes as $tp)
//            {
//                if($tp->getTipo() == $tipCliente)
//                    $pago = $tp->getImporte();
//
//
//            }



//
//            //Estableciendo el pago por tipo de cliente.
//            if($tipCliente == 'VIP')
//            {
//                $pago = 0.00;
//            }
//             if($tipCliente == 'MP')
//             {
//                 $pago = 3.00;
//             }
//             if($tipCliente == 'Full')
//             {
//                 $pago = 6.00;
//             }

            $intervalo = new \DateInterval($this->periodoCobro('m'));
            $time = new \DateTime('now');
            $time->add($intervalo);

            $entityCliente->setFechaDeIngreso(new \DateTime('now'));
            $entityCliente->setFechaDePago($time);
            $entityCliente->setCostoDeservicio($pago);
            $entityCliente->setServicio('Gym');
            $entityCliente->setClave($this->generarClave());
            if($formulario->get('foto')->getData() == null)
                $entityCliente->setFotoRuta('asdfghjkjkkjgh');


            // $tienda = $this->get('security.context')->getToken()->getUser();
            //$oferta->setCompras(0);
            //$oferta->setTienda($tienda);
            //$oferta->setCiudad($tienda->getCiudad());

            //Estableciendo el primer pago del cliente, una vez que se registra.
            $entityPago->setFechaDePago(new \DateTime());
            $entityPago->setPagado(true);
            $entityPago->setCliente($entityCliente);

            $em->persist($entityPago);

            $entityCliente->subirFoto($this->container->getParameter('directorio.imagenes'));//obtiene el dir donde se guarda la foto
            $em->persist($entityCliente);

            //Estableciendo la inscripcion como una visita
            $entityVisita =  new Visita();
            $entityVisita->setCliente($entityCliente);
            $entityVisita->setHora(new \DateTime('now'));
            $entityVisita->setFecha(new \DateTime('now'));
            $em->persist($entityVisita);


            $em->flush();

            $this->get('session')->getFlashBag()->add('registrado',
                '¡Se ha registrado! ');

            $registrado = true;

            $formulario = $this->createForm(new Front\BuscarClienteType(), $entityCliente);

            return $this->render('FrontedBundle:Default:login-full.html.twig',array(
                'formulario'=>$formulario->createView(),
                'clienteBuscado'=>$entityCliente,
            ));

        }




/**/

        return $this->render('FrontedBundle:Default:registration-full.html.twig',array(
            'formulario'=>$formulario->createView(),
        ));

    }

    public function tareasAction ()
    {
        $em = $this->getDoctrine()->getManager();

        $tareas = $em->getRepository('FrontedBundle:Tarea')->findPorFecha(new \DateTime('yesterday 00:00:00'),new \DateTime('tomorrow'));//$em->getRepository('FrontedBundle:Tarea')->findAll();

        return $this->render('FrontedBundle:Default:tareas.html.twig',array(
            'tareas'=>$tareas
        ));
    }

    public function nuevaTareasAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entityTarea = new Tarea();
        $entityTarea->setFechaDeCumplimiento(new \DateTime('tomorrow'));

        $formulario = $this->createForm(new Front\TareasType(),$entityTarea);
        $nuevaTarea = true;

        $tareas = $em->getRepository('FrontedBundle:Tarea')->findPorFecha(new \DateTime('yesterday 00:00:00'),new \DateTime('tomorrow'));


        return $this->render('FrontedBundle:Default:tareas.html.twig',array(
            'nuevaTarea'=>$nuevaTarea,
            'formulario'=>$formulario->createView(),
            'tareas'=>$tareas,
        ));

    }
    public function tareasSaveAction(Request $peticion)
    {
        $em = $this->getDoctrine()->getManager();

        $entityTarea = new Tarea();
        $formulario =  $this->createForm(new Front\TareasType(),$entityTarea);
        $formWeb = $peticion->get('gatorno_frontedbundle_tarea');

        $formulario->handleRequest($peticion);
        if($formulario->isValid())
        {

            $entityTarea->setCumplida(false);
            $entityTarea->setFechaDeCreada(new \DateTime('now'));
            if(!$formWeb['descripcion'])
            {
                $entityTarea->setDescripcion('No hubo descripcion');
            }
            $em->persist($entityTarea);
            $em->flush();

            $this->get('session')->getFlashBag()->add('tarea',
                '¡La tarea se ha creado correctamente! ');
            //variable de control para el flashbag
            $tareaFlashBag = true;
            return $this->redirect($this->generateUrl('fronted_tareas',array('tareaFlashBag'=>$tareaFlashBag)));

        }

        $nuevaTarea = true;
        return $this->render('FrontedBundle:Default:tareas.html.twig',array(
            'nuevaTarea'=>$nuevaTarea,
            'formulario'=>$formulario->createView(),
        ));

    }

    public function editarTareasAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entityTarea = $em->getRepository('FrontedBundle:Tarea')->findOneBy(array('id'=>$id));
        $formulario  = $this->createForm(new Front\TareasEditType(),$entityTarea);

        $tareas = $em->getRepository('FrontedBundle:Tarea')->findPorFecha(new \DateTime('yesterday 00:00:00'),new \DateTime('tomorrow'));

        $editarTarea = true;


        return $this->render('FrontedBundle:Default:tareas.html.twig',array(
            'editarTarea'=>$editarTarea,
            'formulario'=>$formulario->createView(),
            'id'=>$id,
            'tareas'=>$tareas,
        ));

    }

    public function editarTareasSaveAction(Request $peticion,$id)
    {
        $em = $this->getDoctrine()->getManager();

        $entityTarea = new Tarea();
        //$entityTarea->getCreadaPor()AsignadaToTrabajador()Cumplida()FechaDeCreada()
        $formWeb = $peticion->get('gatorno_frontedbundle_tareaEdit');
        $entityTareaId =  $em->getRepository('FrontedBundle:Tarea')->findOneBy(array('id'=>$id));
        //var_dump($formWeb);

        $formulario = $this->createForm(new Front\TareasEditType(),$entityTarea);
        $formulario->handleRequest($peticion);

        if($formulario->isValid())
        {
            /**/

            $cumplida = true;
            if(  !isset($formWeb['cumplida']) or !$formWeb['cumplida'])
                $cumplida = false;

               $fecha = new \DateTime($formWeb['fechaDeCumplimiento']);
            $errorFecha = count($fecha->getLastErrors());
            $em->getRepository('FrontedBundle:Tarea')->findUpdate(
                $id,$formWeb['nombre'],$entityTareaId->getFechaDeCreada(),
                $fecha,$entityTareaId->getAsignadaToTrabajador(),$entityTareaId->getCreadaPor(),
                $formWeb['descripcion'],$cumplida
            );

            //$em->persist($entityTarea);

           // $em->persist($entityTareaId);

            $em->flush();
            $entityTareaId =  $em->getRepository('FrontedBundle:Tarea')->findOneBy(array('id'=>$id));
            //var_dump($entityTareaId);


            $this->get('session')->getFlashBag()->add('tareaEditada',
                '¡La tarea se ha editado correctamente! ');
            //variable de control para el flashbag
            $tareaEditadaFlashBag = true;
            return $this->redirect($this->generateUrl('fronted_tareas',array('tareaEditada'=>$tareaEditadaFlashBag)));

        }
        return $this->render('FrontedBundle:Default:tareas.html.twig');
    }

    public function eliminarTareasAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entityTarea = $em->getRepository('FrontedBundle:Tarea')->findOneBy(array('id'=>$id));
        $em->remove($entityTarea);
        $em->flush();

        return $this->redirect($this->generateUrl('fronted_tareas'));

    }

    ///================================================================================================================
            //FUNCIONES AUXILIARES
    ///================================================================================================================


    public function periodoCobro($var)//establece el periodo de cobro
    {
        if($var == 'm')
        {
            $anno = 0;
            $mes = 1;
            $dia = 0;

            $periodo = 'P'.$anno.'Y'.$mes.'M'.$dia.'D';
            return $periodo;
        }
        if($var == 'd')
        {
            $anno = 0;
            $mes = 0;
            $dia = 3;

            $periodo = 'P'.$anno.'Y'.$mes.'M'.$dia.'D';
            return $periodo;
        }

    }

    public function Gastos()
    {
        $em = $this->getDoctrine()->getManager();

        //GASTOS
        $gastoVariadoEne = $em->getRepository('FrontedBundle:GastosVariados')->findCantPagosHoy(new \DateTime('first day of jan' ), new \DateTime('last day of jan'));
        //var_dump($gastoVariadoEne);
        $gastosVEn = 0;
        if($gastoVariadoEne)
        {
            foreach($gastoVariadoEne as $gastoVariadoEne1)
            {
                $gastosVEn = $gastoVariadoEne1->getMonto() + $gastosVEn;
            }
        }
        $gastoVariadoFeb = $em->getRepository('FrontedBundle:GastosVariados')->findCantPagosHoy(new \DateTime('first day of feb' ), new \DateTime('last day of feb'));
        $gastosVFe = 0;
        if($gastoVariadoFeb)
        {
            foreach($gastoVariadoFeb as $gastoVariadoFeb1)
            {
                $gastosVFe = $gastoVariadoFeb1->getMonto() + $gastosVFe;
            }
        }
        $gastoVariadoMar = $em->getRepository('FrontedBundle:GastosVariados')->findCantPagosHoy(new \DateTime('first day of mar' ), new \DateTime('last day of mar'));
        $gastosVMa = 0;
        if($gastoVariadoMar)
        {
            foreach($gastoVariadoMar as $gastoVariadoMar1)
            {
                $gastosVMa = $gastoVariadoMar1->getMonto() + $gastosVMa;
            }
        }
        $gastoVariadoAbr = $em->getRepository('FrontedBundle:GastosVariados')->findCantPagosHoy(new \DateTime('first day of apr' ), new \DateTime('last day of apr'));
        $gastosVAb = 0;
        if($gastoVariadoAbr)
        {
            foreach($gastoVariadoAbr as $gastoVariadoAbr1)
            {
                $gastosVAb = $gastoVariadoAbr1->getMonto() + $gastosVAb;
            }
        }
        $gastoVariadoMay = $em->getRepository('FrontedBundle:GastosVariados')->findCantPagosHoy(new \DateTime('first day of may' ), new \DateTime('last day of may'));
        $gastosVMay = 0;
        if($gastoVariadoMay)
        {
            foreach($gastoVariadoMay as $gastoVariadoMay1)
            {
                $gastosVMay = $gastoVariadoMay1->getMonto() + $gastosVMay;
            }
        }
        $gastoVariadoJun = $em->getRepository('FrontedBundle:GastosVariados')->findCantPagosHoy(new \DateTime('first day of jun' ), new \DateTime('last day of jun'));
        $gastosVJu = 0;
        if($gastoVariadoJun)
        {
            foreach($gastoVariadoJun as $gastoVariadoJun1)
            {
                $gastosVJu = $gastoVariadoJun1->getMonto() + $gastosVJu;
            }
        }
        $gastoVariadoJul = $em->getRepository('FrontedBundle:GastosVariados')->findCantPagosHoy(new \DateTime('first day of jul' ), new \DateTime('last day of jul'));
        $gastosVJl = 0;
        if($gastoVariadoJul)
        {
            foreach($gastoVariadoJul as $gastoVariadoJul1)
            {
                $gastosVJl = $gastoVariadoJul1->getMonto() + $gastosVJl;
            }
        }
        $gastoVariadoAgo = $em->getRepository('FrontedBundle:GastosVariados')->findCantPagosHoy(new \DateTime('first day of aug' ), new \DateTime('last day of aug'));
        $gastosVAg = 0;
        if($gastoVariadoAgo)
        {
            foreach($gastoVariadoAgo as $gastoVariadoAgo1)
            {
                $gastosVAg = $gastoVariadoAgo1->getMonto() + $gastosVAg;
            }
        }
        $gastoVariadoSep = $em->getRepository('FrontedBundle:GastosVariados')->findCantPagosHoy(new \DateTime('first day of sep' ), new \DateTime('last day of sep'));
        $gastosVSe = 0;
        if($gastoVariadoSep)
        {
            foreach($gastoVariadoSep as $gastoVariadoSep1)
            {
                $gastosVSe = $gastoVariadoSep1->getMonto() + $gastosVSe;
            }
        }
        $gastoVariadoOct = $em->getRepository('FrontedBundle:GastosVariados')->findCantPagosHoy(new \DateTime('first day of oct' ), new \DateTime('last day of oct'));
        $gastosVOc = 0;
        if($gastoVariadoOct)
        {
            foreach($gastoVariadoOct as $gastoVariadoOct1)
            {
                $gastosVOc = $gastoVariadoOct1->getMonto() + $gastosVOc;
            }
        }
        $gastoVariadoNov = $em->getRepository('FrontedBundle:GastosVariados')->findCantPagosHoy(new \DateTime('first day of nov' ), new \DateTime('last day of nov'));
        $gastosVNo = 0;
        if($gastoVariadoNov)
        {
            foreach($gastoVariadoNov as $gastoVariadoNov1)
            {
                $gastosVNo = $gastoVariadoNov1->getMonto() + $gastosVNo;
            }
        }
        $gastoVariadoDic = $em->getRepository('FrontedBundle:GastosVariados')->findCantPagosHoy(new \DateTime('first day of dec' ), new \DateTime('last day of dec'));
        $gastosVDi = 0;
        if($gastoVariadoDic)
        {
            foreach($gastoVariadoDic as $gastoVariadoDic1)
            {
                $gastosVDi = $gastoVariadoDic1->getMonto() + $gastosVDi;
            }
        }

        $anualGastoVariado = $gastosVEn + $gastosVFe + $gastosVMa + $gastosVAb + $gastosVMay + $gastosVJu + $gastosVJl + $gastosVAg + $gastosVSe + $gastosVOc + $gastosVNo + $gastosVDi;


        //TOTAL DE PAGOS DE LOS TRABAJADORES POR MES
        $pagoTrabajdorggggss = $em->getRepository('FrontedBundle:PagoTrabajador')->findAll();
        $pagoTrabajdorEne = $em->getRepository('FrontedBundle:PagoTrabajador')->findFiltroFecha(new \DateTime('first day of jan' ), new \DateTime('last day of jan'));
        $pagoTrabajdorFeb = $em->getRepository('FrontedBundle:PagoTrabajador')->findFiltroFecha(new \DateTime('first day of feb' ), new \DateTime('last day of feb'));
        $pagoTrabajdorMar = $em->getRepository('FrontedBundle:PagoTrabajador')->findFiltroFecha(new \DateTime('first day of mar' ), new \DateTime('last day of mar'));
        $pagoTrabajdorAbr = $em->getRepository('FrontedBundle:PagoTrabajador')->findFiltroFecha(new \DateTime('first day of apr' ), new \DateTime('last day of apr'));
        $pagoTrabajdorMay = $em->getRepository('FrontedBundle:PagoTrabajador')->findFiltroFecha(new \DateTime('first day of may' ), new \DateTime('last day of may'));
        $pagoTrabajdorJun = $em->getRepository('FrontedBundle:PagoTrabajador')->findFiltroFecha(new \DateTime('first day of jun' ), new \DateTime('last day of jun'));
        $pagoTrabajdorJul = $em->getRepository('FrontedBundle:PagoTrabajador')->findFiltroFecha(new \DateTime('first day of jul' ), new \DateTime('last day of jul'));
        $pagoTrabajdorAgo = $em->getRepository('FrontedBundle:PagoTrabajador')->findFiltroFecha(new \DateTime('first day of aug' ), new \DateTime('last day of aug'));
        $pagoTrabajdorSep = $em->getRepository('FrontedBundle:PagoTrabajador')->findFiltroFecha(new \DateTime('first day of sep' ), new \DateTime('last day of sep'));
        $pagoTrabajdorOct = $em->getRepository('FrontedBundle:PagoTrabajador')->findFiltroFecha(new \DateTime('first day of oct' ), new \DateTime('last day of oct'));
        $pagoTrabajdorNov = $em->getRepository('FrontedBundle:PagoTrabajador')->findFiltroFecha(new \DateTime('first day of nov' ), new \DateTime('last day of nov'));
        $pagoTrabajdorDic = $em->getRepository('FrontedBundle:PagoTrabajador')->findFiltroFecha(new \DateTime('first day of dec' ), new \DateTime('last day of dec'));


        //diciembre
        $pagoTrabajdorDi = 0;
        if($pagoTrabajdorDic)
        {
            foreach($pagoTrabajdorDic as $pagoTrabajdorDic1)
            {
                $pagoTrabajdorDi = $pagoTrabajdorDic1->getSalario() + $pagoTrabajdorDi;
            }
        }
        //enero
        $pagoTrabajdorEn = 0;
        if($pagoTrabajdorEne)
        {
            foreach($pagoTrabajdorEne as $pagoTrabajdorEne1)
            {
                $pagoTrabajdorEn = $pagoTrabajdorEne1->getSalario() + $pagoTrabajdorEn;
            }
        }
        //febrero
        $pagoTrabajdorFe = 0;
        if($pagoTrabajdorFeb)
        {
            foreach($pagoTrabajdorFeb as $pagoTrabajdorFeb1)
            {
                $pagoTrabajdorFe = $pagoTrabajdorFeb1->getSalario() + $pagoTrabajdorFe;
            }
        }

        //marzo
        $pagoTrabajdorMa = 0;
        if($pagoTrabajdorMar)
        {
            foreach($pagoTrabajdorMar as $pagoTrabajdorMar1)
            {
                $pagoTrabajdorMa = $pagoTrabajdorMar1->getSalario() + $pagoTrabajdorMa;
            }
        }

        //abril
        $pagoTrabajdorAb = 0;
        if($pagoTrabajdorAbr)
        {
            foreach($pagoTrabajdorAbr as $pagoTrabajdorAbr1)
            {
                $pagoTrabajdorAb = $pagoTrabajdorAbr1->getSalario() + $pagoTrabajdorAb;
            }
        }
        //mayo
        $pagoTrabajdorMayo = 0;
        if($pagoTrabajdorMay)
        {
            foreach($pagoTrabajdorMay as $pagoTrabajdorMay1)
            {
                $pagoTrabajdorMayo = $pagoTrabajdorMay1->getSalario() + $pagoTrabajdorMayo;
            }
        }
        //junio
        $pagoTrabajdorJu = 0;
        if($pagoTrabajdorJun)
        {
            foreach($pagoTrabajdorJun as $pagoTrabajdorJun1)
            {
                $pagoTrabajdorJu = $pagoTrabajdorJun1->getSalario() + $pagoTrabajdorJu;
            }
        }

        //julio
        $pagoTrabajdorJulio = 0;
        if($pagoTrabajdorJul)
        {
            foreach($pagoTrabajdorJul as $pagoTrabajdorJul1)
            {
                $pagoTrabajdorJulio = $pagoTrabajdorJul1->getSalario() + $pagoTrabajdorJulio;
            }
        }
        //agosto
        $pagoTrabajdorAg = 0;
        if($pagoTrabajdorAgo)
        {
            foreach($pagoTrabajdorAgo as $pagoTrabajdorAgo1)
            {
                $pagoTrabajdorAg = $pagoTrabajdorAgo1->getSalario() + $pagoTrabajdorAg;
            }
        }
        //sepptiembre
        $pagoTrabajdorSe = 0;
        if($pagoTrabajdorSep)
        {
            foreach($pagoTrabajdorSep as $pagoTrabajdorSep1)
            {
                $pagoTrabajdorSe = $pagoTrabajdorSep1->getSalario() + $pagoTrabajdorSe;
            }
        }

        //octuble
        $pagoTrabajdorOc = 0;
        if($pagoTrabajdorOct)
        {
            foreach($pagoTrabajdorOct as $pagoTrabajdorOct1)
            {
                $pagoTrabajdorOc = $pagoTrabajdorOct1->getSalario() + $pagoTrabajdorOc;
            }
        }
        //noviembre
        $pagoTrabajdorNo = 0;
        if($pagoTrabajdorNov)
        {
            foreach($pagoTrabajdorNov as $pagoTrabajdorNov1)
            {
                $pagoTrabajdorNo = $pagoTrabajdorNov1->getSalario() + $pagoTrabajdorNo;
            }
        }

        $anualPagoTrabajador = $pagoTrabajdorEn + $pagoTrabajdorFe + $pagoTrabajdorMa +
            $pagoTrabajdorAb + $pagoTrabajdorMayo + $pagoTrabajdorJu + $pagoTrabajdorJulio +
            $pagoTrabajdorAg + $pagoTrabajdorSe + $pagoTrabajdorOc + $pagoTrabajdorNo + $pagoTrabajdorDi;

       // $gastosVEn + $gastosVFe + $gastosVMa + $gastosVAb + $gastosVMay + $gastosVJu + $gastosVJl + $gastosVAg + $gastosVSe + $gastosVOc + $gastosVNo + $gastosVDi;
        return array(
            'anualPagoTrabajador'=>$anualPagoTrabajador,
            'anualGastoVariado'=>$anualGastoVariado,

            'gastosVEn'=>$gastosVEn,
            'gastosVFe'=>$gastosVFe,
            'gastosVMa'=>$gastosVMa,
            'gastosVAb'=>$gastosVAb,
            'gastosVMay'=>$gastosVMay,
            'gastosVJu'=>$gastosVJu,
            'gastosVJl'=>$gastosVJl,
            'gastosVAg'=>$gastosVAg,
            'gastosVSe'=>$gastosVSe,
            'gastosVOc'=>$gastosVOc,
            'gastosVNo'=>$gastosVNo,
            'gastosVDi'=>$gastosVDi,

            'pagoTrabajdorEn'=>$pagoTrabajdorEn,
            'pagoTrabajdorFe'=>$pagoTrabajdorFe,
            'pagoTrabajdorMa'=>$pagoTrabajdorMa,
            'pagoTrabajdorAb'=>$pagoTrabajdorAb,
            'pagoTrabajdorMayo'=>$pagoTrabajdorMayo,
            'pagoTrabajdorJu'=>$pagoTrabajdorJu,
            'pagoTrabajdorJulio'=>$pagoTrabajdorJulio,
            'pagoTrabajdorAg'=>$pagoTrabajdorAg,
            'pagoTrabajdorSe'=>$pagoTrabajdorSe,
            'pagoTrabajdorOc'=>$pagoTrabajdorOc,
            'pagoTrabajdorNo'=>$pagoTrabajdorNo,
            'pagoTrabajdorDi'=>$pagoTrabajdorDi,


        );


    }

    public function generarClave()
    {
        $em = $this->getDoctrine()->getManager();
        //tomar todas la claves
        $todasClaveClientes = $em->getRepository('FrontedBundle:Cliente')->findClaveCliente();

        $rand = 0;
        do{
            $control = true;
            $rand = mt_rand(0,9999);
            foreach($todasClaveClientes as $todasClaveClientes1)
            {
                if(in_array($rand,$todasClaveClientes1))
                {
                    //$rand = mt_rand(0,9999);
                    $control = false;
                    break;
                }
            }


        }while($control == false);




        return $rand;

    }


    /*
     * De una consulta a pago se devuelve un array con los id de los clientes.
     * @param array de consulta a entidad pago
     */
    public function pago_id_cliente($arr)
    {
        $arreglo = array();
        foreach($arr as $a)
        {
            $arreglo[] = $a->getCliente()->getId();

        }
    return $arreglo;

    }


/*
 * Devuelve un arreglo(clave=>valor) donde clave es el KEY del elemento que se repite y VALOR la cantidad de veces repetido
 */

    public function valor_repetidos_array($arreglo)
    {


        $saveJanuary = array_diff_assoc($arreglo, array_unique($arreglo)) ;
        $arregloImplode = array();
        foreach(array_unique($saveJanuary) as $v) {
            $arregloImplode[$v] = count(array_keys($saveJanuary, $v))  ;
        }

        return $arregloImplode;






        //$arr = array('pedro', 'juan', 'paco', 'pedro', 'juan', 'pedro', 'andres');
        //$res = array_diff($arr, array_diff(array_unique($arr), array_diff_assoc($arr, array_unique($arr))));



//        foreach(array_unique($res) as $v) {
//            echo "Duplicado $v en la posicion: " .  implode(', ', array_keys($res, $v)) . '<br />';
//        }
//        Cita:
//        Duplicado pedro en la posicion: 0, 3, 5
//        Duplicado juan en la posicion: 1, 4

    }



}
