<?php

namespace Gatorno\FrontedBundle\Controller;

use Gatorno\FrontedBundle\Entity\Cliente;
use Gatorno\FrontedBundle\Entity\ClienteXMes;
use Gatorno\FrontedBundle\Entity\FakeClienteMes;
use Gatorno\FrontedBundle\Entity\Pago;
use Gatorno\FrontedBundle\Entity\Tarea;
use Gatorno\FrontedBundle\Entity\Visita;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Gatorno\FrontedBundle\Form\Front;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Security\Core\SecurityContext;

class PublicController extends Controller
{

    public function pagoAdelantadoClienteAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entityClientePagoAdelantado = $em->getRepository('FrontedBundle:Cliente')->findOneBy(array('id'=>$id));
        $form = $this->createForm(new Front\PagarPorAdelantadoType());

        //Del indexPublicAction
        $entityClientes = $em->getRepository('FrontedBundle:Cliente')->findBy(
            array('tipo'=>'Full'),
            array('fechaDePago'=>'DESC'),
            40
        );
        $tareasHoy = $em->getRepository('FrontedBundle:Tarea')->findPorFecha(new \DateTime('today 00:00:00'), new \DateTime('today 23:59:00'));
        //var_dump($tareasHoy);
        $cant = count($tareasHoy);

        return $this->render('FrontedBundle:Default:pagoAdelantadoPublic.html.twig',array(
            'form'=>$form->createView(),
            'cant'=>$cant,
            'cliente'=>$entityClientes,
            'tareasHoy'=>$tareasHoy,
            'clienteAdelantado'=>$entityClientePagoAdelantado
        ));

    }
    public function pagoAdelantadoClienteSaveAction(Request $peticion, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $formWeb = $peticion->get('pagoAdelantado');

        $cantMeses = count($formWeb) - 1;



        $entityClientePagoAdelantado = $em->getRepository('FrontedBundle:Cliente')->findOneBy(array('id'=>$id));
        $fechaDepago = $entityClientePagoAdelantado->getFechaDePago();
        //var_dump($fechaDepago);
        $fechaDepago->add($this->intervaloFecha('m',count($formWeb) - 1));
        //var_dump($fechaDepago);
        $form = $this->createForm(new Front\PagarPorAdelantadoType());

        //registrando los pagos
        for ($i = 0; $i < $cantMeses; $i++)
        {
            $pago = new Pago();
            $pago->setPagado(true);
            $pago->setFechaDePago(new \DateTime());
            $pago->setCliente($entityClientePagoAdelantado);
            $em->persist($pago);
        }

        //registrando una visita
        $visita = new Visita();
        $visita->setCliente($entityClientePagoAdelantado);
        $visita->setFecha(new \DateTime());
        $visita->setHora(new \DateTime());
        $em->persist($visita);


        //actualizando fecha de  pago del cliente
        $em->getRepository('FrontedBundle:Cliente')->findUpdateFechaDePago($id, $fechaDepago);
        $em->flush();
        //Del indexPublicAction
        $entityClientes = $em->getRepository('FrontedBundle:Cliente')->findBy(array(),
            array('fechaDeIngreso'=>'DESC'),
            40);
        $tareasHoy = $em->getRepository('FrontedBundle:Tarea')->findPorFecha(new \DateTime('today 00:00:00'), new \DateTime('today 23:59:00'));

        $cant = count($tareasHoy);

        return $this->render('FrontedBundle:Default:pagoAdelantadoPublic.html.twig',array(
            'form'=>$form->createView(),
            'cant'=>$cant,
            'cliente'=>$entityClientes,
            'tareasHoy'=>$tareasHoy,
            'clienteAdelantado'=>$entityClientePagoAdelantado
        ));

    }


    /*
     * Muestra la portada principal de la recepcion
    */
    public function indexPublicAction(Request $peticion)
    {

        $em = $this->getDoctrine()->getManager();

        //lista los ultimos 40 clientes registrados
        $entityClientes = $em->getRepository('FrontedBundle:Cliente')->findBy(array(),
            array('fechaDeIngreso'=>'DESC'),
            40);

        $tareasHoy = $em->getRepository('FrontedBundle:Tarea')->findPorFecha(new \DateTime('today 00:00:00'), new \DateTime('today 23:59:00'));
        $cant = count($tareasHoy);

        //formulario de buscar el cliente
        $formClienteOlvidoClave = $this->createForm(new Front\BuscarClienteOlvidoClaveType());
        $formClienteOlvidoClave->handleRequest($peticion);

        //datos enviados en los campos
        $nombreCampForm = $formClienteOlvidoClave->get('nombre')->getData();
        $apellidoCampForm = $formClienteOlvidoClave->get('apellido')->getData();


        if($formClienteOlvidoClave->isValid())
        {
            $listaCliente = $em->getRepository('FrontedBundle:Cliente')->findClienteNombreApellido($nombreCampForm, $apellidoCampForm);

            return $this->render('FrontedBundle:Default:indexPublic.html.twig',array(
                'tareasHoy'=>$tareasHoy,
                'cant'=>$cant,
                'cliente'=>$listaCliente,
                'formClienteOlvidoClave'=>$formClienteOlvidoClave->createView()
            ));
        }


        return $this->render('FrontedBundle:Default:indexPublic.html.twig',array(
            'tareasHoy'=>$tareasHoy,
            'cant'=>$cant,
            'cliente'=>$entityClientes,
            'formClienteOlvidoClave'=>$formClienteOlvidoClave->createView()
        ));
    }



    public function editClienteAction($id)
    {
        $em = $this->getDoctrine()->getManager();



        $entityCliente = $em->getRepository('FrontedBundle:Cliente')->findOneBy(array('id'=>$id));

        $formulario = $this->createForm(new Front\ClienteEditType(), $entityCliente, array(
            'action' => $this->generateUrl('fronted_cliente_update', array('id' => $entityCliente->getId())),
            'method' => 'PUT',
        ));


        return $this->render('FrontedBundle:Default:clienteEditl.html.twig',array(
            'formulario'=>$formulario->createView(),
        ));

    }

    public function updateClienteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FrontedBundle:Cliente')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Trabajador entity.');
        }


        $formWeb = $request->get('gatorno_frontedbundle_clienteEdit');
        //var_dump($formWeb);

        $editForm = $this->createForm(new Front\ClienteEditType(), $entity, array(
            'action' => $this->generateUrl('fronted_cliente_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));
        $editForm->handleRequest($request);


        if ($editForm->isValid()) {


            //guardando el valor q paga el cliente por el servicio
            //$costo = 0;
            $tipoClienteEntity = $em->getRepository('FrontedBundle:TipoCliente')->findAll();
            foreach ($tipoClienteEntity as $a)
            {
                if($editForm->get('tipo')->getData() == $a->getTipo())
                    $costo = $a->getImporte();
            }

           /* if($editForm->get('tipo')->getData() == 'VIP')
                $costo = 0;
            if($editForm->get('tipo')->getData() == 'MP')
                $costo = 3;
            if($editForm->get('tipo')->getData() == 'Full')
                $costo = 6;*/

            $entity->setCostoDeservicio($costo);

            $entity->subirFoto($this->container->getParameter('directorio.imagenes'));//obtiene el dir donde se guarda la foto

            $em->flush();

            return $this->redirect($this->generateUrl('fronted_public', array('id' => $id)));
        }

        return $this->render('FrontedBundle:Default:clienteEditl.html.twig',array(
            'formulario'=>$editForm->createView(),
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
            ''
        ));
    }


/*
 * Muestra la informacion de los cliente por mes y de los pagos del dia en el public(fake)
 * */
    public function clienteMesAction()
    {
        //SOLUCION
        /*
         * La primera vez que se muestre la vista de los clientes en el public se deben completar los meses que no esten
         * guardado en la base de datos.
         * GENERAR LA CANTIDAD DE CLIENTES DE CADA MES:
         * En caso de usar los datos porcentuales calculados desde datos reales. Calcular el porciento (superior e inferior) de los clientes que pagaron del mes deseado.
         * Generar un numero aleatorio con los dos porcientos calculados y guardarlo en la base de datos.
         *
         * En caso de no usar datos porcentuales generar un numero aleatorio dentro de los limites fijados por el administrador.
         * */

        $em = $this->getDoctrine()->getManager();


        //datos para mostrar en la plantilla.
        $tareasHoy = $em->getRepository('FrontedBundle:Tarea')->findPorFecha(new \DateTime('today 00:00:00'), new \DateTime('today 23:59:00'));
        $cant = count($tareasHoy);

        $intervalo = $em->getRepository('FrontedBundle:FakeClienteMes')->findAll();

        //Limites de clientes pagos a mostrar
        if($intervalo)
            $limiteClientePago = $intervalo[0]->getLimClienteDia();
        else
            $limiteClientePago = 8;


        //pagos de hoy, este valor solo es para mostrar en la plantilla, no es un valor real.
        $clientesPagoHoy = $em->getRepository('FrontedBundle:Pago')->findBy(array('fechaDePago'=>new \DateTime('today')),
            array(), $limiteClientePago);

        //Valor de los clientes por mes.
        $cant_clientes_activos_enero = 0;
        $cant_clientes_activos_febrero = 0;
        $cant_clientes_activos_marzo  = 0;
        $cant_clientes_activos_abril = 0;
        $cant_clientes_activos_mayo  = 0;
        $cant_clientes_activos_junio = 0;
        $cant_clientes_activos_julio  = 0;
        $cant_clientes_activos_agosto  = 0;
        $cant_clientes_activos_septiembre = 0;
        $cant_clientes_activos_octubre = 0;
        $cant_clientes_activos_noviembre = 0;
        $cant_clientes_activos_diciembre = 0;


        //consultar los limites

        if($intervalo)
        {
            //valores configurados por el admin
            $limSuperior = $intervalo[0]->getClienteMesMax();
            $limInferior = $intervalo[0]->getClienteMesMin();
            $porcientoFakeClienteMes = $intervalo[0]->getPorciento();

            //SIEMPRE LOS MESES SE CREARAN TERMINADOS LOS MISMOS
            //ver en la tabla si ya esta definido el valor de la cant de clientes del mes anterior
            //DE NO estar definido el siguiente algoritmo

            $hoy = new \DateTime('now');

            //DE NO estar definido el siguiente algoritmo
            //ver en la tabla si ya esta definido el valor de la cant de clientes del mes anterior
            $clientesXmes = $em->getRepository('FrontedBundle:ClienteXMes')->findBy(array(),array('Mes'=>'DESC'),2);

            if($clientesXmes && ($hoy->format('Y') == $clientesXmes[0]->getMes()->format('Y')))
            {
                //Crear todos los meses que no esten creados en el anno.
                $difMes = $hoy->format('m') - $clientesXmes[0]->getMes()->format('m');//siempre se crearan los datos del mes concluidos.

                    while($difMes > 1)
                    {
                        $difMes--;

                        //Para la definicin porcentual
                        if($porcientoFakeClienteMes)
                        {
                            $clone1 = new \DateTime('now');
                            $clone2 = new \DateTime('now');
                            $mesActivo = $clone1->modify('-'.$difMes.'month');


                            //Para determinar el mes correspondiente y los valores de las fechas inicial y final
                            $fechaInicial = new \DateTime('first day of'.$this->nombreMes($mesActivo->format('m')));
                            $fechaFinal = new \DateTime('last day of'.$this->nombreMes($mesActivo->format('m')));
                            $cantCliente = $em->getRepository('FrontedBundle:Pago')->findCantPagosHoy($fechaInicial, $fechaFinal);

                            $porcientoSup = $limSuperior/100 * count($cantCliente);//limite porcentual superior de la cant de clientes
                            $porcientoInf = $limInferior/100 * count($cantCliente);//limite porcentual inferior de la cant de clientes

                            $cantClienteMesRamdomPorciento = mt_rand($porcientoInf,$porcientoSup);

                            $clienteXMes = new ClienteXMes();
                            $clienteXMes->setClienteXMes($cantClienteMesRamdomPorciento);
                            $clienteXMes->setFechaSave(new \DateTime('now'));
                            $clienteXMes->setMes($clone2->modify('-'.$difMes.'month'));
                            $clienteXMes->setPorciento(1);

                            $em->persist($clienteXMes);
                            $em->flush();


                        }
                        //Para la definicion con valores fijos.
                        else
                        {
                            $cantClienteMesRamdom = mt_rand($limInferior,$limSuperior);
                            $clone = new \DateTime('now');

                            $clienteXMes = new ClienteXMes();
                            $clienteXMes->setClienteXMes($cantClienteMesRamdom);
                            $clienteXMes->setFechaSave(new \DateTime('now'));
                            $clienteXMes->setMes($clone->modify('-'.$difMes.'month'));
                            $clienteXMes->setPorciento(0);

                            $em->persist($clienteXMes);
                            $em->flush();
                        }

                    }

            }
            else//si no existieran datos en ningun mes anterior (primera vez)
            {
                $clone3 = new \DateTime('now');

                $mes = 1;

                //insertar los datos en todos los meses anteriores al presente
                while($clone3->format('m') > $mes)
                {
                    //Para la definicin porcentual
                    if($porcientoFakeClienteMes)
                    {
                        $mesActivo = $this->devuelveMes($mes);

                        //Para determinar el mes correspondiente y los valores de las fechas inicial y final
                        $fechaInicial = new \DateTime('first day of'.$this->nombreMes($mesActivo->format('m')));
                        $fechaFinal = new \DateTime('last day of'.$this->nombreMes($mesActivo->format('m')));
                        $cantCliente = $em->getRepository('FrontedBundle:Pago')->findCantPagosHoy($fechaInicial, $fechaFinal);//rectificar

                        $porcientoSup = $limSuperior/100 * count($cantCliente);//limite porcentual superior de la cant de clientes
                        $porcientoInf = $limInferior/100 * count($cantCliente);//limite porcentual inferior de la cant de clientes


                        $cantClienteMesRamdomPorciento = mt_rand($porcientoInf,$porcientoSup);

                        $clienteXMes = new ClienteXMes();
                        $clienteXMes->setClienteXMes($cantClienteMesRamdomPorciento);
                        $clienteXMes->setFechaSave(new \DateTime('now'));
                        $clienteXMes->setMes($this->devuelveMes($mes));
                        $clienteXMes->setPorciento(1);

                        $em->persist($clienteXMes);
                        $em->flush();

                    }
                    //Para la definicion con valores fijos.
                    else
                    {
                        $cantClienteMesRamdom = mt_rand($limInferior,$limSuperior);
                        $clone = new \DateTime('now');

                        $clienteXMes = new ClienteXMes();
                        $clienteXMes->setClienteXMes($cantClienteMesRamdom);
                        $clienteXMes->setFechaSave(new \DateTime('now'));
                        $clienteXMes->setMes($this->devuelveMes($mes));
                        $clienteXMes->setPorciento(0);

                        $em->persist($clienteXMes);
                        $em->flush();


                    }
                    $mes++;
                }


            }

            //Para el mes de diciembre
            if($clientesXmes && ( $hoy->format('Y') == ($clientesXmes[0]->getMes()->format('Y') + 1)) && $clientesXmes[0]->getMes()->format('m') == 11)
            {
                //Crear todos los meses que no esten creados en el anno.
                $difMes = $hoy->format('m') - $clientesXmes[0]->getMes()->format('m');//siempre se crearan los datos del mes concluidos.

                //Para la definicin porcentual
                if($porcientoFakeClienteMes)
                {
                    $clone1 = new \DateTime('now');
                    $clone2 = new \DateTime('now');
                    $mesActivo = $clone1->modify('- 1 month');
                    $annoAnterior = $mesActivo->format('Y');
                    $fechaInicial = new \DateTime('first day of december');
                    $fechaFinal = new \DateTime('last day of december');
                    $fechaInicial = $fechaInicial->modify('-1 year');
                    $fechaFinal = $fechaFinal->modify('-1 year');

                    $cantCliente = $em->getRepository('FrontedBundle:Pago')->findCantPagosHoy($fechaInicial, $fechaFinal);

                    $porcientoSup = $limSuperior/100 * count($cantCliente);//limite porcentual superior de la cant de clientes
                    $porcientoInf = $limInferior/100 * count($cantCliente);//limite porcentual inferior de la cant de clientes

                    $cantClienteMesRamdomPorciento = mt_rand($porcientoInf,$porcientoSup);

                    $clienteXMes = new ClienteXMes();
                    $clienteXMes->setClienteXMes($cantClienteMesRamdomPorciento);
                    $clienteXMes->setFechaSave(new \DateTime('now'));
                    $clienteXMes->setMes($fechaFinal);
                    $clienteXMes->setPorciento(1);

                    $em->persist($clienteXMes);
                    $em->flush();


                }
                //Para la definicion con valores fijos.
                else
                {
                    $cantClienteMesRamdom = mt_rand($limInferior,$limSuperior);
                    $clone = new \DateTime('now');

                    $fechaFinal = new \DateTime('last day of december');
                    $fechaFinal = $fechaFinal->modify('-1 year');

                    $clienteXMes = new ClienteXMes();
                    $clienteXMes->setClienteXMes($cantClienteMesRamdom);
                    $clienteXMes->setFechaSave(new \DateTime('now'));
                    $clienteXMes->setMes($fechaFinal);
                    $clienteXMes->setPorciento(0);

                    $em->persist($clienteXMes);
                    $em->flush();
                }
            }

            //Para asignar los valores que se van a mostrar en la plantilla
            $clientesXmesUltmos12 = $em->getRepository('FrontedBundle:ClienteXMes')->findBy(array(),array(),12);

            $enero = new \DateTime('january');$feb = new \DateTime('feb');$marzo = new \DateTime('mar');$abril = new \DateTime('april');
            $mayo = new \DateTime('may'); $junio = new \DateTime('jun');$julio = new \DateTime('july'); $agosto = new \DateTime('august');
            $sep = new \DateTime('sep'); $oct = new \DateTime('october'); $nov = new \DateTime('nov'); $dic = new \DateTime('dec');

            foreach($clientesXmesUltmos12 as $a)
            {

                if($a->getMes()->format('Y-M') == $enero->format('Y-M'))
                    $cant_clientes_activos_enero = $a->getClienteXMes();
                if($a->getMes()->format('Y-M') == $feb->format('Y-M'))
                    $cant_clientes_activos_febrero = $a->getClienteXMes();
                if($a->getMes()->format('Y-M') == $marzo->format('Y-M'))
                    $cant_clientes_activos_marzo = $a->getClienteXMes();
                if($a->getMes()->format('Y-M') == $abril->format('Y-M') )
                    $cant_clientes_activos_abril = $a->getClienteXMes();
                if($a->getMes()->format('Y-M') == $mayo->format('Y-M'))
                    $cant_clientes_activos_mayo = $a->getClienteXMes();
                if($a->getMes()->format('Y-M') == $junio->format('Y-M') )
                    $cant_clientes_activos_junio = $a->getClienteXMes();
                if($a->getMes()->format('Y-M') == $julio->format('Y-M'))
                    $cant_clientes_activos_julio = $a->getClienteXMes();
                if($a->getMes()->format('Y-M') == $agosto->format('Y-M'))
                    $cant_clientes_activos_agosto = $a->getClienteXMes();
                if($a->getMes()->format('Y-M') == $sep->format('Y-M'))
                    $cant_clientes_activos_septiembre = $a->getClienteXMes();
                if($a->getMes()->format('Y-M') == $oct->format('Y-M'))
                    $cant_clientes_activos_octubre = $a->getClienteXMes();
                if($a->getMes()->format('Y-M') == $nov->format('Y-M'))
                    $cant_clientes_activos_noviembre = $a->getClienteXMes();


            }


            /*
             * promedio diario = cant cliente mes anterior/26 (es el valor que se suma como cliente)
             * cliente hasta el momento = dia presente * promedio diario
             *
             *
             *
             * */

            //Asignar valor al presente mes (no concluido), al cual no se han asignado valores en la base de datos

            $cantCliente = $em->getRepository('FrontedBundle:ClienteXMes')->findBy(array(),array('Mes'=>'DESC'),1);

            if(count($cantCliente) == 0)
                $promedioDiario = 0;
            else
                $promedioDiario = $cantCliente[0]->getClienteXMes()/26;
            settype($promedioDiario,'int');

            switch($hoy->format('Y-M')){
                case $enero->format('Y-M'):
                    $cant_clientes_activos_enero = $hoy->format('d') * $promedioDiario;
                    break;
                case $feb->format('Y-M'):
                    $cant_clientes_activos_febrero = $hoy->format('d') * $promedioDiario;
                    break;
                case $marzo->format('Y-M'):
                    $cant_clientes_activos_marzo = $hoy->format('d') * $promedioDiario;
                    break;
                case $abril->format('Y-M'):
                    $cant_clientes_activos_abril = $hoy->format('d') * $promedioDiario;
                    break;
                case $mayo->format('Y-M'):
                    $cant_clientes_activos_mayo = $hoy->format('d') * $promedioDiario;
                    break;
                case $junio->format('Y-M'):
                    $cant_clientes_activos_junio = $hoy->format('d') * $promedioDiario;
                    break;
                case $julio->format('Y-M'):
                    $cant_clientes_activos_julio = $hoy->format('d') * $promedioDiario;
                    break;
                case $agosto->format('Y-M'):
                    $cant_clientes_activos_agosto = $hoy->format('d') * $promedioDiario;
                    break;
                case $sep->format('Y-M'):
                    $cant_clientes_activos_septiembre = $hoy->format('d') * $promedioDiario;
                    break;
                case $oct->format('Y-M'):
                    $cant_clientes_activos_octubre = $hoy->format('d') * $promedioDiario;
                    break;
                case $nov->format('Y-M'):
                    $cant_clientes_activos_noviembre = $hoy->format('d') * $promedioDiario;
                    break;
                case $dic->format('Y-M'):
                    $cant_clientes_activos_diciembre = $hoy->format('d') * $promedioDiario;
                    break;

            }


        }


        return $this->render('FrontedBundle:OnatPublic:onatCantClienteMes.html.twig',array(
            'tareasHoy'=>$tareasHoy,
            'cant'=>$cant,
            'clientesPagoHoy'=>$clientesPagoHoy,

        'cant_clientes_activos_enero' => $cant_clientes_activos_enero,
        'cant_clientes_activos_febrero'=>$cant_clientes_activos_febrero ,
        'cant_clientes_activos_marzo'=>$cant_clientes_activos_marzo ,
        'cant_clientes_activos_abril'=>$cant_clientes_activos_abril,
        'cant_clientes_activos_mayo'=>$cant_clientes_activos_mayo ,
        'cant_clientes_activos_junio'=>$cant_clientes_activos_junio ,
        'cant_clientes_activos_julio' =>$cant_clientes_activos_julio,
        'cant_clientes_activos_agosto'=>$cant_clientes_activos_agosto ,
        'cant_clientes_activos_septiembre'=>$cant_clientes_activos_septiembre ,
        'cant_clientes_activos_octubre'=>$cant_clientes_activos_octubre ,
        'cant_clientes_activos_noviembre' =>$cant_clientes_activos_noviembre ,
        'cant_clientes_activos_diciembre' =>$cant_clientes_activos_diciembre ,
        ));
    }












    ///================================================================================================================
            //FUNCIONES AUXILIARES
    ///================================================================================================================



    /*
     * @param $var si va a variar el dias y el mes
     * @param $num la cant de dias o de meses que se desea variar
     */public function intervaloFecha($var, $num)//devuelve un objeto de tipo DateIntervalo
    {
        if($var == 'm')
        {
            $anno = 0;
            $mes = $num;
            $dia = 0;

            $periodo = 'P'.$anno.'Y'.$mes.'M'.$dia.'D';
            return new \DateInterval($periodo);
        }
        if($var == 'd')
        {
            $anno = 0;
            $mes = 0;
            $dia = $num;

            $periodo = 'P'.$anno.'Y'.$mes.'M'.$dia.'D';
            return new \DateInterval($periodo);
        }

        if($var == 'a')
        {
            $anno = 0;
            $mes = 0;
            $dia = $num;

            $periodo = 'P'.$anno.'Y'.$mes.'M'.$dia.'D';
           // return new \DateInterval($periodo);
        }

    }

    /*
     * Como parametro se pasa un entero y devuelve un datetime con el mes igual al parametro del presente anno
     * @param integer
     * */
    public function devuelveMes($var)
    {
        if($var == 1) return new \DateTime('january');
        if($var == 2) return new \DateTime('february');
        if($var == 3) return new \DateTime('march');
        if($var == 4) return new \DateTime('april');
        if($var == 5) return new \DateTime('may');
        if($var == 6) return new \DateTime('jun');
        if($var == 7) return new \DateTime('july');
        if($var == 8) return new \DateTime('august');
        if($var == 9) return new \DateTime('september');
        if($var == 10) return new \DateTime('october');
        if($var == 11) return new \DateTime('november');
        if($var == 12) return new \DateTime('december');
    }

    /*
     * Como parametro se pasa un entero y devuelve un string conrrespondiente al nombre del mes en ingles
     * @param integer
     * */
    public function nombreMes($mes)
    {
        switch ($mes)
        {
            case 1:
                return 'January';
                break;
            case 2:
                return 'February';
                break;
            case 3:
                return 'March';
                break;
            case 4:
                return 'April';
                break;
            case 5:
                return 'May';
                break;
            case 6:
                return 'June';
                break;
            case 7:
                return 'July';
                break;
            case 8:
                return 'August';
                break;
            case 9:
                return 'September';
                break;
            case 10:
                return 'October';
                break;
            case 11:
                return 'November';
                break;
            case 12:
                return 'December';
                break;
            default :
                break;


        }
    }




}
