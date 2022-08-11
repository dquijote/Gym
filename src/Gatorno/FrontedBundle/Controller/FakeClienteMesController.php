<?php

namespace Gatorno\FrontedBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Gatorno\FrontedBundle\Entity\FakeClienteMes;
use Gatorno\FrontedBundle\Form\FakeClienteMesType;

/**
 * FakeClienteMes controller.
 *
 */
class FakeClienteMesController extends Controller
{

    /**
     * Lists all FakeClienteMes entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FrontedBundle:FakeClienteMes')->findAll();

        return $this->render('FrontedBundle:FakeClienteMes:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new FakeClienteMes entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new FakeClienteMes();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {

            /*   //Restrinciones Limite Max > Limite min
            $limiteMax = $form->get('ClienteDiaMax')->getData();
            $limiteMin = $form->get('ClienteDiaMin')->getData();

            if($limiteMax > $limiteMin)
            {
                $em->persist($entity);
                $em->flush();

                return $this->redirect($this->generateUrl('count_dia', array('id' => $entity->getId())));
            }
            else
            {
                $this->get('session')->getFlashBag()->add('errorMaxMin',
                    ' El Límite Máximo debe ser mayor que el Límite Mínimo.'
                );
                return $this->render('FrontedBundle:FakeClienteDia:new.html.twig', array(
                    'entity' => $entity,
                    'form'   => $form->createView(),
                ));
            }*/
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('count', array('id' => $entity->getId())));
        }

        return $this->render('FrontedBundle:FakeClienteMes:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a FakeClienteMes entity.
     *
     * @param FakeClienteMes $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(FakeClienteMes $entity)
    {
        $form = $this->createForm(new FakeClienteMesType(), $entity, array(
            'action' => $this->generateUrl('count_create'),
            'method' => 'POST',
        ));

        //$form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new FakeClienteMes entity.
     *
     */
    public function newAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entity = new FakeClienteMes();
        $form   = $this->createCreateForm($entity);


        $fakeClienteMes =  $em->getRepository('FrontedBundle:FakeClienteMes')->findAll();


        return $this->render('FrontedBundle:FakeClienteMes:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'entities'=>$fakeClienteMes,
        ));
    }

    /**
     * Finds and displays a FakeClienteMes entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FrontedBundle:FakeClienteMes')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FakeClienteMes entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('FrontedBundle:FakeClienteMes:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing FakeClienteMes entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FrontedBundle:FakeClienteMes')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FakeClienteMes entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        $fakeClienteMes = $em->getRepository('FrontedBundle:FakeClienteMes')->findAll();

        return $this->render('FrontedBundle:FakeClienteMes:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'entities'    => $fakeClienteMes,
        ));
    }

    /**
    * Creates a form to edit a FakeClienteMes entity.
    *
    * @param FakeClienteMes $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(FakeClienteMes $entity)
    {
        $form = $this->createForm(new FakeClienteMesType(), $entity, array(
            'action' => $this->generateUrl('count_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        //$form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing FakeClienteMes entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FrontedBundle:FakeClienteMes')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FakeClienteMes entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('count_edit', array('id' => $id)));
        }

        return $this->render('FrontedBundle:FakeClienteMes:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a FakeClienteMes entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FrontedBundle:FakeClienteMes')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find FakeClienteMes entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('count'));
    }

    /**
     * Creates a form to delete a FakeClienteMes entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('count_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
