<?php

namespace Gatorno\FrontedBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Gatorno\FrontedBundle\Entity\FakeClienteDia;
use Gatorno\FrontedBundle\Form\FakeClienteDiaType;

/**
 * FakeClienteDia controller.
 *
 */
class FakeClienteDiaController extends Controller
{

    /**
     * Lists all FakeClienteDia entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FrontedBundle:FakeClienteDia')->findAll();

        return $this->render('FrontedBundle:FakeClienteDia:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new FakeClienteDia entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new FakeClienteDia();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('count_dia', array('id' => $entity->getId())));

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


        }

        return $this->render('FrontedBundle:FakeClienteDia:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a FakeClienteDia entity.
     *
     * @param FakeClienteDia $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(FakeClienteDia $entity)
    {
        $form = $this->createForm(new FakeClienteDiaType(), $entity, array(
            'action' => $this->generateUrl('count_dia_create'),
            'method' => 'POST',
        ));

        //$form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new FakeClienteDia entity.
     *
     */
    public function newAction()
    {
        $entity = new FakeClienteDia();
        $form   = $this->createCreateForm($entity);

        return $this->render('FrontedBundle:FakeClienteDia:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a FakeClienteDia entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FrontedBundle:FakeClienteDia')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FakeClienteDia entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('FrontedBundle:FakeClienteDia:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing FakeClienteDia entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FrontedBundle:FakeClienteDia')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FakeClienteDia entity.');
        }

        $editForm = $this->createEditForm($entity);
        //$deleteForm = $this->createDeleteForm($id);

        $fakeClienteDia = $em->getRepository('FrontedBundle:FakeClienteDia')->findAll();


        return $this->render('FrontedBundle:FakeClienteDia:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'entities'    => $fakeClienteDia,
            //'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a FakeClienteDia entity.
    *
    * @param FakeClienteDia $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(FakeClienteDia $entity)
    {
        $form = $this->createForm(new FakeClienteDiaType(), $entity, array(
            'action' => $this->generateUrl('count_dia_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        //$form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing FakeClienteDia entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FrontedBundle:FakeClienteDia')->find($id);
        $listFakeClienteDia = $em->getRepository('FrontedBundle:FakeClienteDia')->findAll();

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FakeClienteDia entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('count_dia_edit', array('id' => $id)));
        }

        return $this->render('FrontedBundle:FakeClienteDia:edit.html.twig', array(
            'entity'      => $entity,
            'entities'    => $listFakeClienteDia,
            'form'        => $editForm->createView()

        ));
    }
    /**
     * Deletes a FakeClienteDia entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FrontedBundle:FakeClienteDia')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find FakeClienteDia entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('count_dia'));
    }

    /**
     * Creates a form to delete a FakeClienteDia entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('count_dia_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
