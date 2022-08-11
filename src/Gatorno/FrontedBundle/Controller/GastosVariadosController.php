<?php

namespace Gatorno\FrontedBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Gatorno\FrontedBundle\Entity\GastosVariados;
use Gatorno\FrontedBundle\Form\GastosVariadosType;
use Gatorno\FrontedBundle\Form\IntervalDateType;

/**
 * GastosVariados controller.
 *
 */
class GastosVariadosController extends Controller
{

    /**
     * Lists all GastosVariados entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();


        $entities = $em->getRepository('FrontedBundle:GastosVariados')->findPorFecha(new \DateTime('first day of 00:00:00'),new \DateTime('last day of 23:59:00'));
      /*
       * if(!$entities)
        {
            $noHayGastos = true;
            $this->get('session')->getFlashBag()->add('noHayGastos',
                '¡No hay gastos variados! ');
            return $this->redirect($this->generateUrl('gastos_variados', array('noHayGastos' => $noHayGastos)));
        }

       */
        $gastosVariados = true;
        return $this->render('FrontedBundle:GastosVariados:index.html.twig', array(
            'entities' => $entities,
            'gastosVariados'=>$gastosVariados,
        ));
    }

    /**
     * Muestra el formulario para realizar la busqueda
     */
    public function searchAction()
    {
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'begin'=> new \DateTime('now - 2 month'),
            'end'=> new \DateTime('now - 1 month'));

        $form = $this->createForm(new IntervalDateType(),$data);

        return $this->render('FrontedBundle:GastosVariados:search.html.twig', array(
            'IntervalDate'=>$form->createView(),
        ));


    }

    /**
     *Devuelve rusultado de la busqueda
     */
    public function search_resultAction(Request $peticion)
    {
        $em = $this->getDoctrine()->getManager();

        $formInterval = $peticion->request->get('IntervalDate');
        $firstDate = new \DateTime();
        $firstDate->setDate($formInterval['begin']['year'], $formInterval['begin']['month'], $formInterval['begin']['day']);

        $lastDate = new \DateTime();
        $lastDate->setDate($formInterval['end']['year'], $formInterval['end']['month'], $formInterval['end']['day']);

        $data = array(
            'begin'=> $firstDate,
            'end'=> $lastDate);
        $form = $this->createForm(new IntervalDateType(), $data);
        $entities = $em->getRepository('FrontedBundle:GastosVariados')->findPorFecha($firstDate,$lastDate);


        $search_result = true;
        return $this->render('FrontedBundle:GastosVariados:search.html.twig', array(
            'search_result'=>$search_result,
            'IntervalDate'=>$form->createView(),
            'gastosIntervalo'=>$entities,
            'firstDate'=>$firstDate,
            'lastDate'=>$lastDate,
        ));

    }

    /**
     * Creates a new GastosVariados entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new GastosVariados();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('gastos_variados', array('id' => $entity->getId())));
        }

        return $this->render('FrontedBundle:GastosVariados:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a GastosVariados entity.
     *
     * @param GastosVariados $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(GastosVariados $entity)
    {
        $form = $this->createForm(new GastosVariadosType(), $entity, array(
            'action' => $this->generateUrl('gastos_variados_create'),
            'method' => 'POST',
        ));

        //$form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new GastosVariados entity.
     *
     */
    public function newAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FrontedBundle:GastosVariados')->findPorFecha(new \DateTime('first day of 00:00:00'),new \DateTime('last day of 23:59:00'));

        $entity = new GastosVariados();
        $entity->setFecha(new \DateTime('today'));
        $form   = $this->createCreateForm($entity);

        $gastosVariados = true;

        return $this->render('FrontedBundle:GastosVariados:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'entities'=>$entities,
            'gastosVariados'=>$gastosVariados,
        ));
    }

    /**
     * Finds and displays a GastosVariados entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FrontedBundle:GastosVariados')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GastosVariados entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('FrontedBundle:GastosVariados:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing GastosVariados entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FrontedBundle:GastosVariados')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GastosVariados entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        $entities = $em->getRepository('FrontedBundle:GastosVariados')->findPorFecha(new \DateTime('first day of 00:00:00'),new \DateTime('last day of 23:59:00'));

        $gastosVariados = true;
        return $this->render('FrontedBundle:GastosVariados:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'gastosVariados'=>$gastosVariados,
            'entities'=>$entities,
        ));
    }

    /**
    * Creates a form to edit a GastosVariados entity.
    *
    * @param GastosVariados $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(GastosVariados $entity)
    {
        $form = $this->createForm(new GastosVariadosType(), $entity, array(
            'action' => $this->generateUrl('gastos_variados_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

       // $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing GastosVariados entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FrontedBundle:GastosVariados')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GastosVariados entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('gastos_variados', array('id' => $id)));
        }

        return $this->render('FrontedBundle:GastosVariados:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a GastosVariados entity.
     *
     */
    public function deleteAction( $id)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createDeleteForm($id);
       // $form->handleRequest($request);
        $entity = $em->getRepository('FrontedBundle:GastosVariados')->find($id);


        $em->remove($entity);
        $em->flush();
        return $this->redirect($this->generateUrl('gastos_variados'));
    }

    /**
     * Creates a form to delete a GastosVariados entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('gastos_variados_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
