<?php

namespace Gatorno\FrontedBundle\Controller;

use Gatorno\FrontedBundle\Entity\Cliente;
use Gatorno\FrontedBundle\Entity\Pago;
use Gatorno\FrontedBundle\Entity\Visita;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Gatorno\FrontedBundle\Form\Front;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

class PruebasController extends Controller
{
    public function morrisAction()
    {
        $em = $this->getDoctrine()->getManager();



        return $this->render('FrontedBundle:Default:Pruebas\graphs-morris.html.twig');

    }


 /* public function cambiarFechaAction()
  {
      $em = $this->getDoctrine()->getManager();
      for($i = 0;$i < 865;$i++)
      {



          $entityCliente = new Cliente();

          $entityCliente->setServicio('Gym');
          $entityCliente->setFechaDePago(new \DateTime('now'));
          $entityCliente->setFechaDeIngreso(new \DateTime('now'));
          $entityCliente->setApellidos('apellidos');
          $entityCliente->setClave(1);
          $entityCliente->setCostoDeservicio(6);
          $entityCliente->setFotoRuta('');
          $entityCliente->setNombre('nombre');
          $entityCliente->setSexo('hombre');
          $entityCliente->setTipo('FULL');

          $em->persist($entityCliente);
      }


      $em->flush();

      $cadena = '08/06/2015
07/07/2015
07/07/2015
07/07/2015
07/07/2015
07/07/2015
07/07/2015
07/07/2015
07/07/2015
07/07/2015
07/07/2015
07/07/2015
07/07/2015
07/07/2015
07/07/2015
08/07/2015
08/07/2015
08/07/2015
08/07/2015
08/07/2015
08/07/2015
08/07/2015
08/07/2015
08/07/2015
09/07/2015
09/07/2015
09/07/2015
09/07/2015
09/07/2015
09/07/2015
09/07/2015
10/07/2015
10/07/2015
11/07/2015
11/07/2015
12/07/2015
12/07/2015
13/07/2015
13/07/2015
15/07/2015
16/07/2015
17/07/2015
18/07/2015
18/07/2015
20/07/2015
20/07/2015
20/07/2015
20/07/2015
20/07/2015
21/07/2015
21/07/2015
22/07/2015
23/07/2015
23/07/2015
24/07/2015
25/07/2015
25/07/2015
25/07/2015
25/07/2015
27/07/2015
27/07/2015
28/07/2015
29/07/2015
29/07/2015
29/07/2015
29/07/2015
03/08/2015
07/08/2015
08/08/2015
10/08/2015
10/08/2015
10/08/2015
10/08/2015
10/08/2015
10/08/2015
10/08/2015
10/08/2015
13/08/2015
13/08/2015
17/08/2015
17/08/2015
17/08/2015
17/08/2015
19/08/2015
20/08/2015
21/08/2015
22/08/2015
22/08/2015
24/08/2015
24/08/2015
25/08/2015
31/08/2015
31/08/2015
31/08/2015
31/08/2015
02/09/2015
03/09/2015
05/09/2015
07/09/2015
07/09/2015
07/09/2015
07/09/2015
07/09/2015
08/09/2015
08/09/2015
08/09/2015
08/09/2015
09/09/2015
10/09/2015
10/09/2015
10/09/2015
11/09/2015
14/09/2015
14/09/2015
14/09/2015
14/09/2015
16/09/2015
21/09/2015
21/09/2015
21/09/2015
21/09/2015
22/09/2015
22/09/2015
22/09/2015
23/09/2015
23/09/2015
24/09/2015
25/09/2015
25/09/2015
25/09/2015
25/09/2015
26/09/2015
28/09/2015
28/09/2015
29/09/2015
30/09/2015
01/10/2015
01/10/2015
01/10/2015
02/10/2015
02/10/2015
02/10/2015
02/10/2015
02/10/2015
02/10/2015
02/10/2015
03/10/2015
03/10/2015
03/10/2015
03/10/2015
03/10/2015
03/10/2015
05/10/2015
05/10/2015
05/10/2015
05/10/2015
05/10/2015
05/10/2015
05/10/2015
05/10/2015
05/10/2015
05/10/2015
05/10/2015
05/10/2015
05/10/2015
05/10/2015
05/10/2015
05/10/2015
05/10/2015
06/10/2015
06/10/2015
06/10/2015
06/10/2015
06/10/2015
06/10/2015
06/10/2015
06/10/2015
06/10/2015
07/10/2015
07/10/2015
07/10/2015
07/10/2015
07/10/2015
07/10/2015
09/10/2015
09/10/2015
09/10/2015
10/10/2015
10/10/2015
12/10/2015
12/10/2015
12/10/2015
12/10/2015
12/10/2015
12/10/2015
12/10/2015
12/10/2015
12/10/2015
12/10/2015
12/10/2015
12/10/2015
13/10/2015
13/10/2015
13/10/2015
13/10/2015
14/10/2015
14/10/2015
14/10/2015
14/10/2015
14/10/2015
14/10/2015
14/10/2015
14/10/2015
14/10/2015
14/10/2015
14/10/2015
14/10/2015
15/10/2015
15/10/2015
15/10/2015
15/10/2015
15/10/2015
16/10/2015
16/10/2015
16/10/2015
16/10/2015
16/10/2015
16/10/2015
16/10/2015
16/10/2015
17/10/2015
17/10/2015
17/10/2015
17/10/2015
19/10/2015
19/10/2015
19/10/2015
19/10/2015
19/10/2015
19/10/2015
20/10/2015
20/10/2015
20/10/2015
21/10/2015
21/10/2015
21/10/2015
21/10/2015
21/10/2015
21/10/2015
21/10/2015
22/10/2015
22/10/2015
22/10/2015
22/10/2015
22/10/2015
22/10/2015
23/10/2015
23/10/2015
23/10/2015
23/10/2015
24/10/2015
24/10/2015
26/10/2015
26/10/2015
26/10/2015
26/10/2015
26/10/2015
26/10/2015
26/10/2015
26/10/2015
26/10/2015
26/10/2015
26/10/2015
26/10/2015
27/10/2015
27/10/2015
27/10/2015
28/10/2015
28/10/2015
28/10/2015
28/10/2015
28/10/2015
28/10/2015
29/10/2015
30/10/2015
30/10/2015
30/10/2015
02/11/2015
02/11/2015
02/11/2015
02/11/2015
02/11/2015
02/11/2015
02/11/2015
02/11/2015
02/11/2015
02/11/2015
02/11/2015
02/11/2015
02/11/2015
02/11/2015
02/11/2015
02/11/2015
02/11/2015
02/11/2015
02/11/2015
02/11/2015
02/11/2015
02/11/2015
02/11/2015
02/11/2015
02/11/2015
02/11/2015
02/11/2015
02/11/2015
03/11/2015
03/11/2015
03/11/2015
03/11/2015
03/11/2015
03/11/2015
03/11/2015
03/11/2015
03/11/2015
03/11/2015
03/11/2015
03/11/2015
04/11/2015
04/11/2015
04/11/2015
04/11/2015
04/11/2015
04/11/2015
04/11/2015
05/11/2015
05/11/2015
05/11/2015
05/11/2015
05/11/2015
06/11/2015
06/11/2015
06/11/2015
06/11/2015
06/11/2015
07/11/2015
07/11/2015
07/11/2015
07/11/2015
07/11/2015
07/11/2015
08/11/2015
09/11/2015
09/11/2015
09/11/2015
09/11/2015
09/11/2015
09/11/2015
09/11/2015
09/11/2015
09/11/2015
09/11/2015
09/11/2015
09/11/2015
09/11/2015
09/11/2015
09/11/2015
09/11/2015
09/11/2015
09/11/2015
09/11/2015
09/11/2015
09/11/2015
09/11/2015
10/11/2015
10/11/2015
10/11/2015
10/11/2015
11/11/2015
11/11/2015
11/11/2015
11/11/2015
11/11/2015
12/11/2015
12/11/2015
12/11/2015
12/11/2015
12/11/2015
12/11/2015
12/11/2015
12/11/2015
13/11/2015
14/11/2015
15/11/2015
16/11/2015
16/11/2015
16/11/2015
16/11/2015
16/11/2015
16/11/2015
16/11/2015
16/11/2015
16/11/2015
16/11/2015
16/11/2015
16/11/2015
16/11/2015
17/11/2015
17/11/2015
17/11/2015
17/11/2015
17/11/2015
17/11/2015
17/11/2015
17/11/2015
18/11/2015
18/11/2015
18/11/2015
18/11/2015
18/11/2015
19/11/2015
20/11/2015
20/11/2015
23/11/2015
23/11/2015
23/11/2015
23/11/2015
24/11/2015
24/11/2015
24/11/2015
24/11/2015
25/11/2015
25/11/2015
25/11/2015
25/11/2015
25/11/2015
26/11/2015
27/11/2015
27/11/2015
28/11/2015
29/11/2015
30/11/2015
30/11/2015
30/11/2015
30/11/2015
30/11/2015
30/11/2015
30/11/2015
30/11/2015
30/11/2015
30/11/2015
30/11/2015
30/11/2015
01/12/2015
01/12/2015
01/12/2015
01/12/2015
01/12/2015
01/12/2015
01/12/2015
01/12/2015
01/12/2015
01/12/2015
02/12/2015
02/12/2015
02/12/2015
02/12/2015
02/12/2015
02/12/2015
02/12/2015
02/12/2015
02/12/2015
02/12/2015
02/12/2015
02/12/2015
02/12/2015
02/12/2015
02/12/2015
02/12/2015
02/12/2015
02/12/2015
02/12/2015
03/12/2015
03/12/2015
03/12/2015
05/12/2015
05/12/2015
05/12/2015
07/12/2015
07/12/2015
07/12/2015
07/12/2015
07/12/2015
07/12/2015
07/12/2015
07/12/2015
07/12/2015
07/12/2015
07/12/2015
07/12/2015
07/12/2015
07/12/2015
07/12/2015
07/12/2015
07/12/2015
07/12/2015
07/12/2015
07/12/2015
07/12/2015
07/12/2015
07/12/2015
07/12/2015
08/12/2015
08/12/2015
08/12/2015
09/12/2015
09/12/2015
09/12/2015
09/12/2015
09/12/2015
09/12/2015
09/12/2015
09/12/2015
09/12/2015
09/12/2015
09/12/2015
09/12/2015
09/12/2015
10/12/2015
10/12/2015
10/12/2015
10/12/2015
10/12/2015
11/12/2015
11/12/2015
11/12/2015
12/12/2015
14/12/2015
14/12/2015
14/12/2015
14/12/2015
14/12/2015
14/12/2015
14/12/2015
14/12/2015
14/12/2015
14/12/2015
14/12/2015
14/12/2015
14/12/2015
14/12/2015
14/12/2015
14/12/2015
14/12/2015
14/12/2015
14/12/2015
14/12/2015
14/12/2015
14/12/2015
14/12/2015
14/12/2015
14/12/2015
14/12/2015
14/12/2015
14/12/2015
14/12/2015
14/12/2015
14/12/2015
14/12/2015
14/12/2015
14/12/2015
14/12/2015
15/12/2015
15/12/2015
15/12/2015
15/12/2015
16/12/2015
16/12/2015
16/12/2015
16/12/2015
16/12/2015
16/12/2015
16/12/2015
16/12/2015
16/12/2015
17/12/2015
17/12/2015
17/12/2015
18/12/2015
21/12/2015
21/12/2015
21/12/2015
21/12/2015
21/12/2015
21/12/2015
21/12/2015
21/12/2015
21/12/2015
21/12/2015
21/12/2015
21/12/2015
21/12/2015
21/12/2015
21/12/2015
21/12/2015
21/12/2015
21/12/2015
21/12/2015
21/12/2015
21/12/2015
21/12/2015
21/12/2015
21/12/2015
21/12/2015
21/12/2015
21/12/2015
22/12/2015
22/12/2015
22/12/2015
22/12/2015
22/12/2015
23/12/2015
23/12/2015
23/12/2015
23/12/2015
23/12/2015
23/12/2015
23/12/2015
23/12/2015
24/12/2015
24/12/2015
24/12/2015
24/12/2015
25/12/2015
25/12/2015
25/12/2015
25/12/2015
25/12/2015
25/12/2015
27/12/2015
28/12/2015
28/12/2015
28/12/2015
28/12/2015
30/12/2015
30/12/2015
30/12/2015
30/12/2015
03/01/2016
04/01/2016
04/01/2016
04/01/2016
04/01/2016
04/01/2016
04/01/2016
04/01/2016
04/01/2016
04/01/2016
04/01/2016
04/01/2016
04/01/2016
04/01/2016
04/01/2016
04/01/2016
04/01/2016
04/01/2016
04/01/2016
04/01/2016
04/01/2016
04/01/2016
04/01/2016
04/01/2016
04/01/2016
04/01/2016
04/01/2016
04/01/2016
04/01/2016
04/01/2016
04/01/2016
04/01/2016
04/01/2016
04/01/2016
04/01/2016
04/01/2016
04/01/2016
04/01/2016
04/01/2016
04/01/2016
04/01/2016
05/01/2016
05/01/2016
05/01/2016
05/01/2016
05/01/2016
05/01/2016
05/01/2016
05/01/2016
06/01/2016
06/01/2016
06/01/2016
06/01/2016
06/01/2016
06/01/2016
06/01/2016
06/01/2016
06/01/2016
06/01/2016
06/01/2016
06/01/2016
06/01/2016
06/01/2016
06/01/2016
06/01/2016
06/01/2016
06/01/2016
06/01/2016
07/01/2016
07/01/2016
07/01/2016
07/01/2016
08/01/2016
08/01/2016
08/01/2016
08/01/2016
08/01/2016
08/01/2016
08/01/2016
08/01/2016
08/01/2016
08/01/2016
08/01/2016
09/01/2016
09/01/2016
09/01/2016
09/01/2016
11/01/2016
11/01/2016
11/01/2016
11/01/2016
11/01/2016
11/01/2016
11/01/2016
11/01/2016
11/01/2016
11/01/2016
11/01/2016
11/01/2016
11/01/2016
11/01/2016
11/01/2016
11/01/2016
11/01/2016
11/01/2016
11/01/2016
11/01/2016
11/01/2016
11/01/2016
11/01/2016
11/01/2016
11/01/2016
11/01/2016
11/01/2016
11/01/2016
11/01/2016
11/01/2016
11/01/2016
11/01/2016
11/01/2016
11/01/2016
11/01/2016
11/01/2016
11/01/2016
11/01/2016
11/01/2016
11/01/2016
11/01/2016
11/01/2016
11/01/2016
11/01/2016
11/01/2016
11/01/2016
12/01/2016
12/01/2016
12/01/2016
12/01/2016
12/01/2016
12/01/2016
12/01/2016
13/01/2016
13/01/2016
13/01/2016
13/01/2016
13/01/2016
13/01/2016
13/01/2016
13/01/2016
13/01/2016
13/01/2016
13/01/2016
13/01/2016
13/01/2016
13/01/2016
13/01/2016
13/01/2016
13/01/2016
14/01/2016
14/01/2016
14/01/2016
14/01/2016
14/01/2016
14/01/2016
14/01/2016
14/01/2016
15/01/2016
15/01/2016
15/01/2016
15/01/2016
15/01/2016
15/01/2016
15/01/2016
15/01/2016
16/01/2016
16/01/2016
18/01/2016
18/01/2016
18/01/2016
18/01/2016
18/01/2016
18/01/2016
18/01/2016
18/01/2016
18/01/2016
18/01/2016
18/01/2016
18/01/2016
18/01/2016
18/01/2016
18/01/2016
18/01/2016
18/01/2016
18/01/2016
18/01/2016
18/01/2016
18/01/2016
18/01/2016
18/01/2016
18/01/2016
18/01/2016
18/01/2016
18/01/2016
18/01/2016
18/01/2016
18/01/2016
18/01/2016
18/01/2016
18/01/2016
18/01/2016
18/01/2016
18/01/2016';

      $array = $this->cambiarFormatoFecha($cadena);
      //$array = trim($array);
      $cad = '';
      foreach($array as $array1)
      {
          $cad = "\n".$cad.$array1;
      }


      return $this->render('FrontedBundle:Default:Pruebas\index.html.twig',array(
          'cadena'=>$array,
          'cad'=>$cad,

      ));
  }*/

    public function cambiarBaseDatosAction()
    {
        $em = $this->getDoctrine()->getManager();
        for($i = 0;$i < 895; $i++ )
        {
            $entity = new Cliente();

            $entity->setNombre('');
            $entity->setFechaDePago(new \DateTime());
            $entity->setTipo('');
            $entity->setSexo('');
            $entity->setApellidos('');
            $entity->setFotoRuta('');
            $entity->setClave(9);
            $entity->setServicio('');
            $entity->setFechaDeIngreso(new \DateTime());
            $entity->setCostoDeservicio(9);

            $em->persist($entity);


        } $em->flush();
    }

    public function cambiarFechaAction()
    {
        $array = array();
        for($i = 0; $i < 907; $i++)
        {
            $array[$i] = 'Full';
        }

        $cad = '';
        return $this->render('FrontedBundle:Default:Pruebas\index.html.twig',array(
            'cadena'=>$array,
            'cad'=>$cad,

        ));
    }

    public function cambiarFormatoFecha($cadena)
    {
        $a = trim($cadena);
        $cadena = trim($a);
        $cadena = str_replace("/","-",$cadena);


        $array  = array();

        for($i = 0; $i < strlen ($cadena)-11;$i= $i + 11)
        {
            $dia = $cadena{0 + $i}.$cadena{1 + $i};
            $mes = $cadena{3 + $i}.$cadena{4 + $i};
            $anno = $cadena{6 + $i}.$cadena{7 + $i}.$cadena{8 + $i}.$cadena{9 + $i};

            $array[$i] = $anno."-".$mes."-".$dia;
        }
        return $array;
    }
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();



        return $this->render('FrontedBundle:Default:Pruebas\index.html.twig');
    }

    public function avancedTableAction()
    {
        $em = $this->getDoctrine()->getManager();



        return $this->render('FrontedBundle:Default:Pruebas\avanced-table.html.twig');
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
        ));
    }

    public function cambiarFechaPagoClienteSaveAction(Request $peticion)
    {

        $em = $this->getDoctrine()->getManager();

        $formWeb = $peticion->get('gatorno_frontedbundle_FechaPago');

        $entityCliente = new Cliente();
        $formulario = $this->createForm(new Front\ClienteFechaPagoType(),$entityCliente);
        $formulario->handleRequest($peticion);

        if($formulario->isValid())
        {
            //obteniendo el cliente mediante la clave
            $cliente = $em->getRepository('FrontedBundle:Cliente')->findOneBy(array('clave'=>$formWeb['clave']));

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

                //estableciendo la fecha de pago
                $intervalo = new \DateInterval($this->periodoCobro('m'));
                $time = new \DateTime('now');
                $time->add($intervalo);


                //actualizar los datos del cliente que se reincorpora
                $em->getRepository('FrontedBundle:Cliente')->findUpdateReincorporacion(
                    $cliente->getId(),
                    $formWeb['nombre'],
                    $formWeb['apellidos'],
                    $time,
                    $formWeb['tipo'],
                    $formWeb['servicio'],
                    $costo
                );

                $clienteDepuesDeActualizar = $em->getRepository('FrontedBundle:Cliente')->findOneBy(array('clave'=>$formWeb['clave']));

                //registrar el pago
                $entityPago = new Pago();
                $entityPago->setCliente($clienteDepuesDeActualizar);
                $entityPago->setFechaDePago(new \DateTime('now'));
                $entityPago->setPagado(true);

                $em->persist($entityPago);
                $em->flush();

                $clienteDepuesDeActualizar = $em->getRepository('FrontedBundle:Cliente')->findOneBy(array('clave'=>$formWeb['clave']));

                //creando los datos necesarios para la vista buscar
                $formularioBuscar =  $this->createForm(new Front\BuscarClienteType()) ;
                return $this->render('FrontedBundle:Default:login-full.html.twig',array(
                    'formulario'=>$formularioBuscar->createView(),
                    'clienteBuscado'=>$clienteDepuesDeActualizar,
                    //'noEncontrado'=>$noEncontrado,
                    //'clienteBuscadoFechaDePago'=>$clienteBuscadoFechaDePago,

                ));
            }

        }



        $cliente->setFechaDeIngreso(new \DateTime());
        $cliente->setFechaDePago(new \DateTime());

        $formulario = $this->createForm(new Front\ClienteFechaPagoType(),$cliente);
        //$formulario = $this-> BuscarClienteType();



        return $this->render('FrontedBundle:Default:cambiarFechaPago.html.twig',array(
            'formulario'=>$formulario->createView(),
            'cliente'=>$cliente,
        ));
    }

    public function buscarClienteAction(Request $peticion)
    {
        $em = $this->getDoctrine()->getManager();

        $formWeb = $peticion->get('frontedbundle_cliente_buscar');
        $entityCliente = new Cliente();

        $formulario = $this->createForm(new Front\BuscarClienteType(),$entityCliente);
        $formulario->handleRequest($peticion);



        if($formulario->isValid())
        {
            $entityVisita = new Visita();//para registrarlo como una visita, en caso de que exista
            $clienteBuscado = $em->getRepository('FrontedBundle:Cliente')->findOneBy(array('clave'=>$formWeb['clave']));

            $pagado = false;


            if($clienteBuscado)
            {

                //var_dump($clienteBuscado);
                /*
                 * Registrar como una visita cada vez que el cliente se busque.
                 */
                $entityVisita->setCliente($clienteBuscado);
                $entityVisita->setFecha(new \DateTime('now'));
                $entityVisita->setHora(new \DateTime('now'));

                $em->persist($entityVisita);
                $em->flush();


                //buscando el ultimo pago del cliente. No se utilizo
                $ultimoPagoCliente = $em->getRepository('FrontedBundle:Pago')->findBy(
                    array('cliente'=>$clienteBuscado->getId()),
                    array('fechaDePago'=>'DESC'),
                    1
                );
                foreach($ultimoPagoCliente as $pago)
                {
                   $fechaUltimoPago = $pago->getFechaDePago();
                }

                //Restandonle 3 dias a la fecha de pago para mostrar el boton de pagar a partir de 3 dias antes.
                //(no modifica el valor de la entidad )
                $intervaloFechaDePago = new \DateInterval($this->periodoCobro('d'));
                $newDate = new \DateTime();
               // $clienteBuscadoFechaDePago = $clienteBuscado->getFechaDePago();//SE ESTAN RESTANDO A LA ENTIDAD, NO SE PUEDE MODIFICAR ESE VALOR
               // $clienteBuscadoFechaDePago->sub($intervaloFechaDePago);
                //$clienteBuscadoFechaDePago = new \DateTime();


            }


            if(!$clienteBuscado)
            {
                $this->get('session')->getFlashBag()->add('noEncontrado',
                    '¡No se encuentra registrado! ');
                $noEncontrado = true;
                $clienteBuscadoFechaDePago = false;
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
            $pago = 0;

            //Estableciendo el pago por tipo de cliente.
            if($tipCliente == 'VIP')
            {
                $pago = 0.00;
            }
             if($tipCliente == 'MP')
             {
                 $pago = 3.00;
             }
             if($tipCliente == 'Full')
             {
                 $pago = 6.00;
             }

            $intervalo = new \DateInterval($this->periodoCobro('m'));
            $time = new \DateTime('now');
            $time->add($intervalo);

            $entityCliente->setFechaDeIngreso(new \DateTime('now'));
            $entityCliente->setFechaDePago($time);
            $entityCliente->setCostoDeservicio($pago);

           // $tienda = $this->get('security.context')->getToken()->getUser();
            //$oferta->setCompras(0);
            //$oferta->setTienda($tienda);
            //$oferta->setCiudad($tienda->getCiudad());

            //Estableciendo el primer pago del cliente, una vez que se registra.
            $entityPago->setFechaDePago(new \DateTime());
            $entityPago->setPagado(true);
            $entityPago->setCliente($entityCliente);

            $em->persist($entityPago);

            $entityCliente->subirFoto($this->container->getParameter('directorio.imagenes'));//obtiene la el dir donde se guarda la foto
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

            $formulario = $this->createForm(new Front\ClienteType());
            return $this->render('FrontedBundle:Default:registration-full.html.twig',array(
                'formulario'=>$formulario->createView(),
                'registrado'=>$registrado,
            ));

        }




/**/

        return $this->render('FrontedBundle:Default:registration-full.html.twig',array(
            'formulario'=>$formulario->createView(),
        ));

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


}
