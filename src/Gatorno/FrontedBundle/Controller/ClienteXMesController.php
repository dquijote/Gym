<?php

namespace Gatorno\FrontedBundle\Controller;

use Gatorno\FrontedBundle\Form\BuscarAnnoClienteXMesType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Gatorno\FrontedBundle\Entity\ClienteXMes;
use Gatorno\FrontedBundle\Form\ClienteXMesType;

/**
 * ClienteXMes controller.
 *
 */
class ClienteXMesController extends Controller
{

    /**
     * Lists all ClienteXMes entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FrontedBundle:ClienteXMes')->findBy(array(),array(), 12);

        $formBuscar = $this->createForm(new BuscarAnnoClienteXMesType());

        return $this->render('FrontedBundle:ClienteXMes:index.html.twig', array(
            'entities' => $entities,
            'form'     => $formBuscar->createView()
        ));
    }

    /*
     *Busca los meses dado un anno
     * */
    public function buscarAnnoClienteXmesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        //formulario
        $form = $this->createForm(new BuscarAnnoClienteXMesType());
        $form->handleRequest($request);

        if($form->isValid())
        {
            //tomando los datos enviados en el formulario
            $anno = $form->get('fecha')->getData();

            $fechaInicial = new \DateTime();
            $fechaInicial->setDate($anno,1,1);//modificando al primer dia del anno dado por el usuario
            $fechaInicial->setTime(0,0,0);

            $fechaFinal = new \DateTime();
            $fechaFinal->setDate($anno,12,31);//modificando al ultimo dia del anno dado por el usuario
            $fechaFinal->setTime(12,59,59);
            $entities = $em->getRepository('FrontedBundle:ClienteXMes')->findAnnoClienteXMes($fechaInicial, $fechaFinal);


        }


        $formBuscar = $this->createForm(new BuscarAnnoClienteXMesType());

        return $this->render('FrontedBundle:ClienteXMes:index.html.twig', array(
            'entities' => $entities,
            'form'     => $formBuscar->createView()
        ));

    }
    /**
     * Creates a new ClienteXMes entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new ClienteXMes();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('cliente_mes_show', array('id' => $entity->getId())));
        }

        return $this->render('FrontedBundle:ClienteXMes:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a ClienteXMes entity.
     *
     * @param ClienteXMes $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(ClienteXMes $entity)
    {
        $form = $this->createForm(new ClienteXMesType(), $entity, array(
            'action' => $this->generateUrl('cliente_mes_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new ClienteXMes entity.
     *
     */
    public function newAction()
    {
        $entity = new ClienteXMes();
        $form   = $this->createCreateForm($entity);

        return $this->render('FrontedBundle:ClienteXMes:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ClienteXMes entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FrontedBundle:ClienteXMes')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ClienteXMes entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('FrontedBundle:ClienteXMes:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing ClienteXMes entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FrontedBundle:ClienteXMes')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ClienteXMes entity.');
        }

        $entities = $em->getRepository('FrontedBundle:ClienteXMes')->findBy(array(),array(), 11);

        //mostrando el fomulario de busqueda por anno
        $formBuscar = $this->createForm(new BuscarAnnoClienteXMesType());

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('FrontedBundle:ClienteXMes:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'form'        => $formBuscar->createView(),
            'entities'    => $entities
        ));
    }

    /**
    * Creates a form to edit a ClienteXMes entity.
    *
    * @param ClienteXMes $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(ClienteXMes $entity)
    {
        $form = $this->createForm(new ClienteXMesType(), $entity, array(
            'action' => $this->generateUrl('cliente_mes_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        //$form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing ClienteXMes entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FrontedBundle:ClienteXMes')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ClienteXMes entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $entity->setFechaSave(new \DateTime('now'));
            $em->flush();

            return $this->redirect($this->generateUrl('cliente_mes_edit', array('id' => $id)));
        }

        return $this->render('FrontedBundle:ClienteXMes:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a ClienteXMes entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FrontedBundle:ClienteXMes')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ClienteXMes entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('cliente_mes'));
    }

    /**
     * Creates a form to delete a ClienteXMes entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cliente_mes_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
