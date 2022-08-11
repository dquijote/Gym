<?php

namespace Gatorno\FrontedBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Gatorno\FrontedBundle\Entity\Trabajador;
use Gatorno\FrontedBundle\Form\Front;
use Gatorno\FrontedBundle\Form\TrabajadorEditType;

/**
 * Trabajador controller.
 *
 */
class TrabajadorController extends Controller
{

    /**
     * Lists all Trabajador entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FrontedBundle:Trabajador')->findAll();

        $trabajador = true;

        return $this->render('FrontedBundle:Trabajador:index.html.twig', array(
            'entities' => $entities,
            'trabajador'=>$trabajador,
        ));
    }
    /**
     * Creates a new Trabajador entity.
     *
     */
    public function createAction(Request $request)
    {
        $formWeb = $request->get('gatorno_frontedbundle_trabajador');
        $entity = new Trabajador();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            if($form->get('foto')->getData() == null)
                $entity->setFotoRuta('asdfghjkjkkjgh');
            $entity->subirFoto($this->container->getParameter('directorio.imagenes.trabajador'));//obtiene el dir donde se guarda la foto

            $em->persist($entity);
            $em->flush();


            return $this->redirect($this->generateUrl('trabajador', array('id' => $entity->getId())));
        }

        return $this->render('FrontedBundle:Trabajador:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Trabajador entity.
     *
     * @param Trabajador $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Trabajador $entity)
    {
        $form = $this->createForm(new Front\TrabajadorType(), $entity, array(
            'action' => $this->generateUrl('trabajador_create'),
            'method' => 'POST',
        ));

        //$form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Trabajador entity.
     *
     */
    public function newAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entity = new Trabajador();
        $entity->setFechaDeIngreso(new \DateTime('today'));
        $entity->setFechaDePago(new \DateTime('first day of next month'));
        $form   = $this->createCreateForm($entity);

        $entities = $em->getRepository('FrontedBundle:Trabajador')->findAll();
        $trabajador = true;

        return $this->render('FrontedBundle:Trabajador:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'entities'=>$entities,
            'trabajador'=>$trabajador
        ));
    }

    /**
     * Finds and displays a Trabajador entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FrontedBundle:Trabajador')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Trabajador entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('FrontedBundle:Trabajador:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Trabajador entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FrontedBundle:Trabajador')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Trabajador entity.');
        }

        $entities = $em->getRepository('FrontedBundle:Trabajador')->findAll();
        $trabajador = true;


        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('FrontedBundle:Trabajador:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'entities'=>$entities,
            'trabajador'=>$trabajador
        ));
    }

    /**
    * Creates a form to edit a Trabajador entity.
    *
    * @param Trabajador $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Trabajador $entity)
    {
        $form = $this->createForm(new TrabajadorEditType(), $entity, array(
            'action' => $this->generateUrl('trabajador_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

       // $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Trabajador entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $formWeb = $request->get('gatorno_frontedbundle_trabajadorEdit');
        var_dump($formWeb);

        $entity = $em->getRepository('FrontedBundle:Trabajador')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Trabajador entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            /*
             *   if(!$formWeb['foto'])
            {
                $entity->subirFoto($this->container->getParameter('directorio.imagenes.trabajador'));//obtiene el dir donde se guarda la foto

            }
             */

            $em->flush();

            return $this->redirect($this->generateUrl('trabajador', array('id' => $id)));
        }

        return $this->render('FrontedBundle:Trabajador:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Trabajador entity.
     *
     */
    public function deleteAction( $id)
    {
        $form = $this->createDeleteForm($id);
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FrontedBundle:Trabajador')->find($id);
        //borrar las tareas asignadas a este trabajador
        $entityTareaTrabajador = $em->getRepository('FrontedBundle:Tarea')->findBy(array('asignadaToTrabajador'=>$id));
        if($entityTareaTrabajador)
            foreach($entityTareaTrabajador as $entityTareaTrabajador1)
            {
                $em->remove($entityTareaTrabajador1);
            }

        //borrar los pagos a este trabajador
        $entityPagoTrabajador = $em->getRepository('FrontedBundle:PagoTrabajador')->findBy(array('trabajador'=>$id));
        if($entityPagoTrabajador)
            foreach($entityPagoTrabajador as $entityPagoTrabajador1)
            {
                $em->remove($entityPagoTrabajador1);
            }




            if (!$entity) {
                throw $this->createNotFoundException('No se puede encontrar el trabajdor.');

            }


        $entityTrabajadorGastosVariados = $em->getRepository('FrontedBundle:GastosVariados')->findBy(array('trabajador'=>$id));
        foreach($entityTrabajadorGastosVariados as $entityTrabajadorGastosVariados1)
        {
            $em->remove($entityTrabajadorGastosVariados1);

        }

            $em->remove($entity);
            $em->flush();


        return $this->redirect($this->generateUrl('trabajador'));
    }

    /**
     * Creates a form to delete a Trabajador entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('trabajador_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
