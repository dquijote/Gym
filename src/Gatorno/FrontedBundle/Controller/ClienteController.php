<?php

namespace Gatorno\FrontedBundle\Controller;

use Gatorno\FrontedBundle\Form\Front\BuscarClienteType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\Tools\Pagination\Paginator;

use Gatorno\FrontedBundle\Entity\Cliente;
use Gatorno\FrontedBundle\Form\ClienteType;
use Gatorno\FrontedBundle\Form\Admin;

/**
 * Cliente controller.
 *
 */
class ClienteController extends Controller
{

    /**
     * Lists all Cliente entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(new BuscarClienteType());

        //$entities = $em->getRepository('FrontedBundle:Cliente')->findAll();

        return $this->render('FrontedBundle:Cliente:indexClientes.html.twig', array(
            //  'entities' => $entities,
            'formulario'=>$form->createView(),
        ));
    }
    /*
     * Busca un cliente por la clave
     */
    public function buscarAction(Request $peticion)
    {
        $em = $this->getDoctrine()->getManager();

        $entity =  new Cliente();
        $formWeb = $peticion->request->get('frontedbundle_cliente_buscar');//tomando el formulario
        $clave = $formWeb['clave'];

        $form = $this->createForm(new BuscarClienteType(),$entity);
        $form->handleRequest($peticion);

        if($form->isValid())
        {
            $clienteBuscado = $em->getRepository('FrontedBundle:Cliente')->findOneBy(array('clave'=>$clave));

            if($clienteBuscado)
            {
                return $this->render('FrontedBundle:Cliente:indexClientes.html.twig', array(
                    'formulario'=>$form->createView(),
                    'clienteBuscado'=>$clienteBuscado,
                ));
            }
            else
            {
                //mensaje: "no se ha podido encontrar al cliente"
                $this->get('session')->getFlashBag()->add('clienteNoEcontrado',
                    '¡No se ha podido encontrar el cliente solicitado! ');

                return $this->render('FrontedBundle:Cliente:indexClientes.html.twig', array(
                    'formulario'=>$form->createView(),
                ));
            }

        }

        return $this->render('FrontedBundle:Cliente:indexClientes.html.twig', array(
            'formulario'=>$form->createView(),
        ));




    }

    /**
     * Creates a new Cliente entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Cliente();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('cliente_show', array('id' => $entity->getId())));
        }

        return $this->render('FrontedBundle:Cliente:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Cliente entity.
     *
     * @param Cliente $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Cliente $entity)
    {
        $form = $this->createForm(new ClienteType(), $entity, array(
            'action' => $this->generateUrl('cliente_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Cliente entity.
     *
     */
    public function newAction()
    {
        $entity = new Cliente();
        $form   = $this->createCreateForm($entity);

        return $this->render('FrontedBundle:Cliente:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Cliente entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FrontedBundle:Cliente')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cliente entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('FrontedBundle:Cliente:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Cliente entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FrontedBundle:Cliente')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cliente entity.');
        }

        $formulario = $this->createForm(new BuscarClienteType());
        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('FrontedBundle:Cliente:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'formulario'=>$formulario->createView(

            ),
        ));
    }

    /**
     * Creates a form to edit a Cliente entity.
     *
     * @param Cliente $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Cliente $entity)
    {
        $form = $this->createForm(new ClienteType(), $entity, array(
            'action' => $this->generateUrl('cliente_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        //$form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Cliente entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FrontedBundle:Cliente')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cliente entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            if($editForm->get('tipo')->getData() == 'VIP')
                $costo = 0;
            if($editForm->get('tipo')->getData() == 'MP')
                $costo = 3;
            if($editForm->get('tipo')->getData() == 'Full')
                $costo = 6;

            $costo = 0;
            $importeTipoCliente = $em->getRepository('FrontedBundle:TipoCliente')->findAll();
            foreach ($importeTipoCliente as $a)
            {
                if($editForm->get('tipo')->getData() == $a->getTipo())
                    $costo = $a->getImporte();
            }


            $entity->setCostoDeservicio($costo);

            $entity->subirFoto($this->container->getParameter('directorio.imagenes'));//obtiene el dir donde se guarda la foto


            $em->flush();

            return $this->redirect($this->generateUrl('cliente_despues_update', array('id' => $id)));
        }

        return $this->render('FrontedBundle:Cliente:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /*
     *Despues de editar el cliente muestra la vista de index con el cliente modificado
     */
    public function afterEdithAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $clienteBuscado = $em->getRepository('FrontedBundle:Cliente')->findOneBy(array('id'=>$id));
        $form = $this->createForm(new BuscarClienteType());

        // $entities = $em->getRepository('FrontedBundle:Cliente')->findAll();

        return $this->render('FrontedBundle:Cliente:indexClientes.html.twig', array(
            'formulario'=>$form->createView(),
            'clienteBuscado'=>$clienteBuscado,
        ));
    }
    /*
     * Confirmar la eliminacion del cliente
     */
    public function confirmDeleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $clienteAdelantado = $em->getRepository('FrontedBundle:Cliente')->findOneBy(array('id'=>$id));

        $formulario = $this->createForm(new BuscarClienteType());
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('FrontedBundle:Cliente:confirmDelete.html.twig', array(
            'formulario'=>$formulario->createView(),
            'clienteAdelantado'=>$clienteAdelantado,
            'deleteForm'=>$deleteForm->createView(),
        ));

    }
    /**
     * Deletes a Cliente entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FrontedBundle:Cliente')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Cliente entity.');
            }

            $pagos = $em->getRepository('FrontedBundle:Pago')->findBy(array('cliente'=>$id));
            $visitas = $em->getRepository('FrontedBundle:Visita')->findBy(array('cliente'=>$id));

            //eliminando los pagos relacionados con el cliente
            foreach($pagos as $pagos1)
            {
                $em->remove($pagos1);

            }

            //eliminando las visitas relacionadas con el cliente
            foreach($visitas as $visitas1)
            {
                $em->remove($visitas1);

            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('cliente'));
    }

    /**
     * Filtrar a los clientes por los diferentes parametros
     */
    public function clienteFiltroAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entityCliente = new Cliente();

//        Formulario
        $formulario = $this->createForm(new Admin\ClienteFiltroType(),$entityCliente);
        $formulario->handleRequest($request);

        $fechaDeIngreso = "";
        $fechaDeIngresoFin = "";
        $fechaDePago = "";
        $fechaDePagoFin = "";
        $genero = "";
        $tipo_cliente = "";
        $page = "";
        $firstResult = "";
        $maxResults = 50;
        $costo = "";
        $data_tipo_obj = "";
        $id_tipo_cliente = "";

        $control = $request->query->get("control");
        $data = $request->query->get("gatorno_frontedbundle_cliente_filtro");

        if ($data != "" && $data != null){
            $data_fechaDeIngreso = $data["fechaDeIngreso"];
            $data_fechaDeIngresoFin = $data["fechaDeIngresoFin"];
            $data_fechaDePago = $data["fechaDePago"];
            $data_fechaDePagoFin = $data["fechaDePagoFin"];
            $data_tipo = $data["tipo"];
            $genero = $data["sexo"];
            $page = 1;

            //Setting value $firstResult
            if (($page * $maxResults - ($maxResults - 1)) >= 1){
                $firstResult = $page * $maxResults - ($maxResults - 1);
            }

            if ($data["tipo"] != ""){
                $data_tipo_obj = $em->getRepository("FrontedBundle:TipoCliente")->find($data["tipo"]);
                $tipo_cliente = $data_tipo_obj->getTipo();
                $costo = $data_tipo_obj->getImporte();
                $id_tipo_cliente = $data_tipo_obj->getId();
            }
            if ($data_fechaDeIngreso["year"] != "" && $data_fechaDeIngreso["month"] != "" && $data_fechaDeIngreso["day"] != "" &&
                $data_fechaDeIngresoFin["year"] != "" && $data_fechaDeIngresoFin["month"] != "" && $data_fechaDeIngresoFin["day"] != "") {
                $fechaDeIngreso = new \DateTime();
                $fechaDeIngresoFin = new \DateTime();
                $fechaDeIngreso->setDate($data_fechaDeIngreso["year"], $data_fechaDeIngreso["month"], $data_fechaDeIngreso["day"]);
                $fechaDeIngresoFin->setDate($data_fechaDeIngresoFin["year"], $data_fechaDeIngresoFin["month"], $data_fechaDeIngresoFin["day"]);
            }
            if ($data_fechaDePago["year"] != "" && $data_fechaDePago["month"] != "" && $data_fechaDePago["day"] != "" &&
                $data_fechaDePagoFin["year"] != "" && $data_fechaDePagoFin["month"] != "" && $data_fechaDePagoFin["day"] != "" ){
                $fechaDePago = new \DateTime();
                $fechaDePagoFin = new \DateTime();
                $fechaDePago->setDate($data_fechaDePago["year"], $data_fechaDePago["month"], $data_fechaDePago["day"]);
                $fechaDePagoFin->setDate($data_fechaDePagoFin["year"], $data_fechaDePagoFin["month"], $data_fechaDePagoFin["day"]);

            }
            // Costo
//            if ($data_tipo_obj)

        }
        elseif ($control){
            $fechaDeIngreso = $request->query->get("fechaDeIngreso");
            if ($fechaDeIngreso != "" && $fechaDeIngreso != null){
                $fechaDeIngreso = date_create($fechaDeIngreso["date"]);
            }

            $fechaDeIngresoFin = $request->query->get("fechaDeIngresoFin");
            if ($fechaDeIngresoFin != "" && $fechaDeIngresoFin != null){
                $fechaDeIngresoFin = date_create($fechaDeIngresoFin["date"]);
            }

            $fechaDePago = $request->query->get("fechaDePago");
            if ($fechaDePago != "" && $fechaDePago != null){
                $fechaDePago = date_create($fechaDePago["date"]);
            }

            $fechaDePagoFin = $request->query->get("fechaDePagoFin");
            if ($fechaDePagoFin != "" && $fechaDePagoFin != null){
                $fechaDePagoFin = date_create($fechaDePagoFin["date"]);
            }
            $page = $request->query->get("page");
            $genero = $request->query->get("genero");


            //Setting value $firstResult
            if (($page * $maxResults - ($maxResults - 1)) >= 1){
                $firstResult = $page * $maxResults - ($maxResults - 1);
            }

            $tipo_cliente = $request->query->get("tipoCliente");
            if ($tipo_cliente != ""){
                $data_tipo_obj = $em->getRepository("FrontedBundle:TipoCliente")->find($tipo_cliente);
                $tipo_cliente = $data_tipo_obj->getTipo();
                $costo = $data_tipo_obj->getImporte();
                $id_tipo_cliente = $data_tipo_obj->getId();
            }


        }


//Fecha de ingreso solo
        if ($fechaDeIngreso != ""&& $fechaDeIngreso != null && $fechaDeIngresoFin != "" && $fechaDeIngresoFin != null &&
            $fechaDePago == "" && $fechaDePagoFin == "" && $tipo_cliente == "" && $genero == "") {

            $consulta = $em->getRepository("FrontedBundle:cliente")->findFiltroFechaPaginator($fechaDeIngreso, $fechaDeIngresoFin);

            $paginator = new Paginator($consulta);
//            $limit = 5;
            $maxPages = ceil($paginator->count() / $maxResults);
            $thisPage = $page;
            $paginator->getQuery()->setFirstResult($firstResult)->setMaxResults($maxResults);
            //$maxPages = $paginator->count();


            return $this->render('FrontedBundle:Cliente:clienteReporte.html.twig', array(
                'formulario'=>$formulario->createView(),
                //'clienteBuscado'=>$querry_cliente,
                "cantCliente" => count($paginator),
                "fecha_ingreso_inicio"=>$fechaDeIngreso,
                "fecha_ingreso_fin"=>$fechaDeIngresoFin,
                "fechaDePago" => $fechaDePago,
                "fechaDePagoFin" => $fechaDePagoFin,
                "genero" => $genero,
                "tipoCliente" => $id_tipo_cliente,

                "thisPage" => $thisPage,
                "maxPages" => $maxPages,
                "paginator" => $paginator,
            ));

        }
//Fecha de ingreso y Tipo de cliente
        if ($fechaDeIngreso != "" && $fechaDeIngreso != null && $fechaDeIngresoFin != "" && $fechaDeIngresoFin != null &&
            $fechaDePago == "" && $fechaDePagoFin == "" && $tipo_cliente != "" && $genero == "") {

            $consulta = $em->getRepository("FrontedBundle:cliente")->findFiltroFechaTipoPaginator($fechaDeIngreso, $fechaDeIngresoFin, $tipo_cliente);
            $paginator = new Paginator($consulta);

//            $limit = 5;
            $maxPages = ceil($paginator->count() / $maxResults);
            $thisPage = $page;
            $paginator->getQuery()->setFirstResult($firstResult)->setMaxResults($maxResults);

            return $this->render('FrontedBundle:Cliente:clienteReporte.html.twig', array(
                'formulario'=>$formulario->createView(),
               // 'clienteBuscado'=>$querry_cliente,
                "cantCliente" => count($paginator),
                "fecha_ingreso_inicio"=>$fechaDeIngreso,
                "fecha_ingreso_fin"=>$fechaDeIngresoFin,
                "fechaDePago" => $fechaDePago,
                "fechaDePagoFin" => $fechaDePagoFin,
                "genero" => $genero,
                "tipoClienteObj" => $data_tipo_obj,
                "tipoCliente" => $id_tipo_cliente,
                "costo" => $costo,

                "thisPage" => $thisPage,
                "maxPages" => $maxPages,
                "paginator" => $paginator,
//            'deleteForm'=>$deleteForm->createView(),
            ));

        }
//Fecha de ingreso y genero de cliente
        if ($fechaDeIngreso != ""&& $fechaDeIngreso != null && $fechaDeIngresoFin != "" && $fechaDeIngresoFin != null &&
            $fechaDePago == "" && $fechaDePagoFin == "" && $tipo_cliente == "" && $genero != "" && $genero != null) {

            $consulta = $em->getRepository("FrontedBundle:cliente")->findFiltroFechaSexoPaginator($fechaDeIngreso, $fechaDeIngresoFin, $genero);

            $paginator = new Paginator($consulta);
//            $limit = 5;
            $maxPages = ceil($paginator->count() / $maxResults);
            $thisPage = $page;
            $paginator->getQuery()->setFirstResult($firstResult)->setMaxResults($maxResults);

            return $this->render('FrontedBundle:Cliente:clienteReporte.html.twig', array(
                'formulario'=>$formulario->createView(),
                //'clienteBuscado'=>$querry_cliente,
                "cantCliente" => count($paginator),
                "fecha_ingreso_inicio"=>$fechaDeIngreso,
                "fecha_ingreso_fin"=>$fechaDeIngresoFin,
                "fechaDePago" => $fechaDePago,
                "fechaDePagoFin" => $fechaDePagoFin,
                "genero" => $genero,
                "tipoCliente" => $id_tipo_cliente,

                "thisPage" => $thisPage,
                "maxPages" => $maxPages,
                "paginator" => $paginator,
//            'deleteForm'=>$deleteForm->createView(),
            ));
        }

//Fecha de ingreso + genero de cliente + tipo de cliente
        if ($fechaDeIngreso != ""&& $fechaDeIngreso != null && $fechaDeIngresoFin != "" && $fechaDeIngresoFin != null &&
            $fechaDePago == "" && $fechaDePagoFin == "" && $tipo_cliente != "" && $genero != "") {

            $consulta = $em->getRepository("FrontedBundle:cliente")->findFiltroFechaSexoTipoPaginator(
                $fechaDeIngreso,
                $fechaDeIngresoFin,
                $genero,
                $tipo_cliente
            );

            $paginator = new Paginator($consulta);
//            $limit = 5;
            $maxPages = ceil($paginator->count() / $maxResults);
            $thisPage = $page;
            $paginator->getQuery()->setFirstResult($firstResult)->setMaxResults($maxResults);


            return $this->render('FrontedBundle:Cliente:clienteReporte.html.twig', array(
                'formulario'=>$formulario->createView(),
                //'clienteBuscado' => $querry_cliente,
                "cantCliente" => count($paginator),
                "fecha_ingreso_inicio"=>$fechaDeIngreso,
                "fecha_ingreso_fin"=>$fechaDeIngresoFin,
                "fechaDePago" => $fechaDePago,
                "fechaDePagoFin" => $fechaDePagoFin,
                "genero" => $genero,
                "tipoClienteObj" => $data_tipo_obj,
                "tipoCliente" => $id_tipo_cliente,
                "costo" => $costo,

                "thisPage" => $thisPage,
                "maxPages" => $maxPages,
                "paginator" => $paginator,
//            'deleteForm'=>$deleteForm->createView(),
            ));
        }

//  Fecha de pago solo
        if ($fechaDeIngreso == ""&& $fechaDeIngreso == null && $fechaDeIngresoFin == "" && $fechaDeIngresoFin == null &&
            $fechaDePago != "" && $fechaDePagoFin != "" && $tipo_cliente == "" && $genero == ""){

            $consulta = $em->getRepository("FrontedBundle:cliente")->findFechaDePagoPaginator($fechaDePago, $fechaDePagoFin);

            $paginator = new Paginator($consulta);
//            $limit = 5;
            $maxPages = ceil($paginator->count() / $maxResults);
            $thisPage = $page;
            $paginator->getQuery()->setFirstResult($firstResult)->setMaxResults($maxResults);

            return $this->render('FrontedBundle:Cliente:clienteReporte.html.twig', array(
                'formulario'=>$formulario->createView(),
               // 'clienteBuscado'=>$querry_cliente,
                "cantCliente" => count($paginator),
                "fecha_ingreso_inicio"=>$fechaDeIngreso,
                "fecha_ingreso_fin"=>$fechaDeIngresoFin,
                "fechaDePago" => $fechaDePago,
                "fechaDePagoFin" => $fechaDePagoFin,
                "genero" => $genero,
                "tipoCliente" => $id_tipo_cliente,

                "thisPage" => $thisPage,
                "maxPages" => $maxPages,
                "paginator" => $paginator,
            ));

        }
//  Fecha de pago y sexo
        if ($fechaDeIngreso == ""&& $fechaDeIngreso == null && $fechaDeIngresoFin == "" && $fechaDeIngresoFin == null &&
            $fechaDePago != "" && $fechaDePagoFin != "" && $tipo_cliente == "" && $genero != ""){

            $consulta = $em->getRepository("FrontedBundle:cliente")->findRangeFechaDePagoSexoPaginator($fechaDePago, $fechaDePagoFin, $genero);

            $paginator = new Paginator($consulta);
//            $limit = 5;
            $maxPages = ceil($paginator->count() / $maxResults);
            $thisPage = $page;
            $paginator->getQuery()->setFirstResult($firstResult)->setMaxResults($maxResults);
            //$maxPages = $paginator->count();


            return $this->render('FrontedBundle:Cliente:clienteReporte.html.twig', array(
                'formulario'=>$formulario->createView(),
                //'clienteBuscado'=>$querry_cliente,
                "cantCliente" => count($paginator),
                "fecha_ingreso_inicio"=>$fechaDeIngreso,
                "fecha_ingreso_fin"=>$fechaDeIngresoFin,
                "fechaDePago" => $fechaDePago,
                "fechaDePagoFin" => $fechaDePagoFin,
                "genero" => $genero,
                "tipoCliente" => $id_tipo_cliente,

                "thisPage" => $thisPage,
                "maxPages" => $maxPages,
                "paginator" => $paginator,
            ));
        }
//        Fecha de pago y tipo
        if ($fechaDeIngreso == ""&& $fechaDeIngreso == null && $fechaDeIngresoFin == "" && $fechaDeIngresoFin == null &&
            $fechaDePago != "" && $fechaDePagoFin != "" && $tipo_cliente != "" && $genero == ""){
            $consulta = $em->getRepository("FrontedBundle:cliente")->findRangeFechaDePagoTipoPaginator($fechaDePago, $fechaDePagoFin, $tipo_cliente);
            $paginator = new Paginator($consulta);

//            $limit = 5;
            $maxPages = ceil($paginator->count() / $maxResults);
            $thisPage = $page;
            $paginator->getQuery()->setFirstResult($firstResult)->setMaxResults($maxResults);

            return $this->render('FrontedBundle:Cliente:clienteReporte.html.twig', array(
                'formulario'=>$formulario->createView(),
                // 'clienteBuscado'=>$querry_cliente,
                "cantCliente" => $paginator->count(),
                "fecha_ingreso_inicio"=>$fechaDeIngreso,
                "fecha_ingreso_fin"=>$fechaDeIngresoFin,
                "fechaDePago" => $fechaDePago,
                "fechaDePagoFin" => $fechaDePagoFin,
                "genero" => $genero,
                "tipoClienteObj" => $data_tipo_obj,
                "tipoCliente" => $id_tipo_cliente,
                "costo" => $costo,

                "thisPage" => $thisPage,
                "maxPages" => $maxPages,
                "paginator" => $paginator,
//            'deleteForm'=>$deleteForm->createView(),
            ));
        }

//        Fecha de pago + tipo + sexo
        if ($fechaDeIngreso == "" && $fechaDeIngreso == null && $fechaDeIngresoFin == "" && $fechaDeIngresoFin == null &&
            $fechaDePago != "" && $fechaDePagoFin != "" && $tipo_cliente != "" && $genero != ""){

            $consulta = $em->getRepository("FrontedBundle:cliente")->findRangeFechaDePagoTipoSexoPaginator(
                $fechaDePago,
                $fechaDePagoFin,
                $tipo_cliente,
                $genero
            );

            $paginator = new Paginator($consulta);
//            $limit = 5;
            $maxPages = ceil($paginator->count() / $maxResults);
            $thisPage = $page;
            $paginator->getQuery()->setFirstResult($firstResult)->setMaxResults($maxResults);


            return $this->render('FrontedBundle:Cliente:clienteReporte.html.twig', array(
                'formulario'=>$formulario->createView(),
                //'clienteBuscado' => $querry_cliente,
                "cantCliente" => $paginator->count(),
                "fecha_ingreso_inicio"=>$fechaDeIngreso,
                "fecha_ingreso_fin"=>$fechaDeIngresoFin,
                "fechaDePago" => $fechaDePago,
                "fechaDePagoFin" => $fechaDePagoFin,
                "genero" => $genero,
                "tipoClienteObj" => $data_tipo_obj,
                "tipoCliente" => $id_tipo_cliente,
                "costo" => $costo,

                "thisPage" => $thisPage,
                "maxPages" => $maxPages,
                "paginator" => $paginator,
//            'deleteForm'=>$deleteForm->createView(),
            ));
        }

        //}



        return $this->render('FrontedBundle:Cliente:clienteReporte.html.twig', array(
            'formulario'=>$formulario->createView(),
//            'clienteAdelantado'=>$clienteAdelantado,
//            'deleteForm'=>$deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to delete a Cliente entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cliente_delete', array('id' => $id)))
            ->setMethod('DELETE')
            // ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
            ;
    }
}
