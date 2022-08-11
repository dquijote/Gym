<?php

namespace Gatorno\FrontedBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Gatorno\FrontedBundle\Entity\appUser;
use Gatorno\FrontedBundle\Form\appUserType;
use Gatorno\FrontedBundle\Form\appUserEditType;
//use Symfony\Component\Validator\Constraints\Null;

/**
 * appUser controller.
 *
 */
class appUserController extends Controller
{

    /**
     * Lists all appUser entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FrontedBundle:appUser')->findAll();

        return $this->render('FrontedBundle:appUser:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new appUser entity.
     *
     */
    public function createAction(Request $peticion)
    {
        $usuario = new appUser();
        $formulario = $this->createForm(new appUserType(), $usuario);
        $formulario->handleRequest($peticion);

        if ($formulario->isValid())
        {
            $encoder = $this->get('security.encoder_factory')->getEncoder($usuario);
            $usuario->setSalt('');//md5(time())
            $passwordCodificado = $encoder->encodePassword(
                $usuario->getPassword(),
                $usuario->getSalt()
            );
            $usuario->setPassword($passwordCodificado);

            $em = $this->getDoctrine()->getManager();
            $em->persist($usuario);
            $em->flush();


            $this->get('session')->getFlashBag()->add('registrado',
                ' Se ha registrado correctamente.'
            );
            //varible de control del flashBAg
            $registradoFlashBag = true;
/*
 *  //loguear al user cuando se registra
            $token = new UsernamePasswordToken(
                $usuario,
                $usuario->getPassword(),
                'frontend',
                $usuario->getRoles()
            );
            $this->container->get('security.context')->setToken($token);
 */


            //
            return $this->redirect($this->generateUrl('user',array('registradoFlashBag'=>$registradoFlashBag)));


        }
        return $this->render(
            'FrontedBundle:appUser:new.html.twig', array(
                'form' => $formulario->createView(),
                'entity' => $usuario,

            )
        );

    }

    /**
     * Creates a form to create a appUser entity.
     *
     * @param appUser $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(appUser $entity)
    {
        $form = $this->createForm(new appUserType(), $entity, array(
            'action' => $this->generateUrl('user_create'),
            'method' => 'POST',
        ));

        //$form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new appUser entity.
     *
     */
    public function newAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FrontedBundle:appUser')->findAll();

        $entity = new appUser();
        $form   = $this->createCreateForm($entity);

        return $this->render('FrontedBundle:appUser:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'entities'=>$entities
        ));
    }

    /**
     * Finds and displays a appUser entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FrontedBundle:appUser')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find appUser entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('FrontedBundle:appUser:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing appUser entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FrontedBundle:appUser')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find appUser entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        $entities = $em->getRepository('FrontedBundle:appUser')->findAll();


        return $this->render('FrontedBundle:appUser:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'entities'=>$entities
        ));
    }

    /**
    * Creates a form to edit a appUser entity.
    *
    * @param appUser $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(appUser $entity)
    {
        $form = $this->createForm(new appUserEditType(), $entity, array(
            'action' => $this->generateUrl('user_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        //$form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing appUser entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FrontedBundle:appUser')->find($id);
        $pass = $entity->getPassword();
        $a = new appUser();
       // $a->setPassword();




        $entity = $em->getRepository('FrontedBundle:appUser')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find appUser entity.');
        }

        //=======
        $editForm = $this->createForm(new appUserEditType(), $entity, array(
            'action' => $this->generateUrl('user_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));
        //=======
        $passwordOriginal = $editForm->getData()->getPassword();

        $deleteForm = $this->createDeleteForm($id);
       // $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        //si esta vacio el pass (no lo quiere actualizar) poner el pass anterior

        $formWeb = $request->get('gatorno_frontedbundle_appuserEdit');


       // if ($editForm->isValid()) {}

            if(!$formWeb['password'])
            {
                //update the entity appUser through the Repository
                $entity->setPassword($passwordOriginal);var_dump($entity);
                $em->getRepository('FrontedBundle:appUser')->Update($entity, $id);
            }
            else
                $em->flush();

            return $this->redirect($this->generateUrl('user', array('id' => $id)));


        return $this->render('FrontedBundle:appUser:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a appUser entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        /*if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FrontedBundle:appUser')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find appUser entity.');
            }

            $em->remove($entity);
            $em->flush();
        }*/
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FrontedBundle:appUser')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se puede encontrar el usuario.');
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('user'));
    }

    /**
     * Creates a form to delete a appUser entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
