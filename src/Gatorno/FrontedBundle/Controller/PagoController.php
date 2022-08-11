<?php

namespace Gatorno\FrontedBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Gatorno\FrontedBundle\Entity\Pago;
use Gatorno\FrontedBundle\Form\PagoType;

/**
 * Pago controller.
 *
 */
class PagoController extends Controller
{

    /**
     * Lists all Pago entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FrontedBundle:Pago')->findAll();

        return $this->render('FrontedBundle:Pago:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Pago entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Pago();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('pagosClientes_show', array('id' => $entity->getId())));
        }

        return $this->render('FrontedBundle:Pago:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Pago entity.
     *
     * @param Pago $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Pago $entity)
    {
        $form = $this->createForm(new PagoType(), $entity, array(
            'action' => $this->generateUrl('pagosClientes_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Pago entity.
     *
     */
    public function newAction()
    {
        $entity = new Pago();
        $form   = $this->createCreateForm($entity);

        return $this->render('FrontedBundle:Pago:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Pago entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FrontedBundle:Pago')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pago entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('FrontedBundle:Pago:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Pago entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FrontedBundle:Pago')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pago entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('FrontedBundle:Pago:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Pago entity.
    *
    * @param Pago $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Pago $entity)
    {
        $form = $this->createForm(new PagoType(), $entity, array(
            'action' => $this->generateUrl('pagosClientes_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Pago entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FrontedBundle:Pago')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pago entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('pagosClientes_edit', array('id' => $id)));
        }

        return $this->render('FrontedBundle:Pago:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Confirm Deletes a Pago entity.
     *
     */
    public function confirm_deleteAction( $id)
    {
        $em = $this->getDoctrine()->getManager();

        $cliente = $em->getRepository('FrontedBundle:Pago')->findOneBy(array('id'=>$id));
        if(!$cliente)
        {
          throw $this->createNotFoundException('Imposible encontrar el pago solicitado.');

        }

        //mostrando los pagos del dia
        $entityClientePago = $em->getRepository('FrontedBundle:Pago')->findCantPagosHoy(new \DateTime('today 00:00:00'), new \DateTime('today 23:50:00'));


        //$cliente = $em->getRepository('FrontedBundle:Cliente')->findOneBy(array('id'=>$clientePago->getCliente()));

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('FrontedBundle:PagosClientes:confirmDelete.html.twig', array(
            'deleteForm' => $deleteForm->createView(),
            'clienteAdelantado'=>$cliente,
            'entityClientePago'=>$entityClientePago,
        ));

    }
    /**
     * Deletes a Pago entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FrontedBundle:Pago')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Pago entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('pagos_clientes_index'));
    }

    /**
     * Creates a form to delete a Pago entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pagosClientes_delete', array('id' => $id)))
            ->setMethod('DELETE')
            //->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
