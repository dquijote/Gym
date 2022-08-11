<?php

namespace Gatorno\FrontedBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Gatorno\FrontedBundle\Entity\Cargo;
use Gatorno\FrontedBundle\Form\CargoType;

/**
 * Cargo controller.
 *
 */
class CargoController extends Controller
{

    /**
     * Lists all Cargo entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FrontedBundle:Cargo')->findAll();

        return $this->render('FrontedBundle:Cargo:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Cargo entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Cargo();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('cargo', array('id' => $entity->getId())));
        }

        return $this->render('FrontedBundle:Cargo:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Cargo entity.
     *
     * @param Cargo $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Cargo $entity)
    {
        $form = $this->createForm(new CargoType(), $entity, array(
            'action' => $this->generateUrl('cargo_create'),
            'method' => 'POST',
        ));

      //  $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Cargo entity.
     *
     */
    public function newAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FrontedBundle:Cargo')->findAll();
        $entity = new Cargo();
        $form   = $this->createCreateForm($entity);

        return $this->render('FrontedBundle:Cargo:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'entities'=>$entities
        ));
    }

    /**
     * Finds and displays a Cargo entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FrontedBundle:Cargo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cargo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('FrontedBundle:Cargo:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Cargo entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FrontedBundle:Cargo')->find($id);

        $entities = $em->getRepository('FrontedBundle:Cargo')->findAll();

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cargo entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('FrontedBundle:Cargo:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'entities'=>$entities
        ));
    }

    /**
    * Creates a form to edit a Cargo entity.
    *
    * @param Cargo $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Cargo $entity)
    {
        $form = $this->createForm(new CargoType(), $entity, array(
            'action' => $this->generateUrl('cargo_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        //$form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Cargo entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FrontedBundle:Cargo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cargo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('cargo', array('id' => $id)));
        }

        return $this->render('FrontedBundle:Cargo:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Cargo entity.
     *
     */
    public function deleteAction( $id)
    {
        $form = $this->createDeleteForm($id);

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FrontedBundle:Cargo')->find($id);
        $entityPlazaTrabajador = $em->getRepository('FrontedBundle:Trabajador')->findBy(array('cargo'=>$id));
        if($entityPlazaTrabajador)
        {
            $this->get('session')->getFlashBag()->add('plazaFlashBag',
                '¡Esta plaza no se puede eliminar porque esta asignada a un trabajador ! ');
            $plazaFlashBag = 2;
            return $this->redirect($this->generateUrl('cargo',array('plazaFlashBag'=>$plazaFlashBag)));
        }



            if (!$entity) {
                throw $this->createNotFoundException('No se puede encontrar la entidad cargo.');
            }

            $em->remove($entity);
            $em->flush();


        return $this->redirect($this->generateUrl('cargo'));
    }

    /**
     * Creates a form to delete a Cargo entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cargo_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
