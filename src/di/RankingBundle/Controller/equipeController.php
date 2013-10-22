<?php

namespace di\RankingBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use di\RankingBundle\Entity\equipe;
use di\RankingBundle\Form\equipeType;

/**
 * equipe controller.
 *
 * @Route("/equipe")
 */
class equipeController extends Controller
{

    /**
     * Lists all equipe entities.
     *
     * @Route("/", name="equipe")
     * @Secure(roles="ROLE_ADMIN")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('diRankingBundle:equipe')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new equipe entity.
     *
     * @Route("/newTeam", name="equipe_create")
     * @Method("POST")
     * @Secure(roles="ROLE_ADMIN")
     * @Template("diRankingBundle:equipe:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new equipe();
        
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('equipe_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a equipe entity.
    *
    * @param equipe $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(equipe $entity)
    {
        $form = $this->createForm(new equipeType(), $entity, array(
            'action' => $this->generateUrl('equipe_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new equipe entity.
     *
     * @Route("/new", name="equipe_new")
     * @Method("GET")
     * @Secure(roles="ROLE_ADMIN")
     * @Template()
     */
    public function newAction()
    {
        $entity = new equipe();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a equipe entity.
     *
     * @Route("/{id}", name="equipe_show")
     * @Method("GET")
     * @Secure(roles="ROLE_ADMIN")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('diRankingBundle:equipe')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find equipe entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing equipe entity.
     *
     * @Route("/{id}/edit", name="equipe_edit")
     * @Method("GET")
     * @Secure(roles="ROLE_ADMIN")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('diRankingBundle:equipe')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find equipe entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a equipe entity.
    *
    * @param equipe $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(equipe $entity)
    {
        $form = $this->createForm(new equipeType(), $entity, array(
            'action' => $this->generateUrl('equipe_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing equipe entity.
     *
     * @Route("/{id}", name="equipe_update")
     * @Method("PUT")
     * @Secure(roles="ROLE_ADMIN")
     * @Template("diRankingBundle:equipe:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('diRankingBundle:equipe')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find equipe entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('equipe_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a equipe entity.
     *
     * @Route("/{id}", name="equipe_delete")
     * @Method("DELETE")
     * @Secure(roles="ROLE_ADMIN")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('diRankingBundle:equipe')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find equipe entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('di_dashboard'));
    }

    /**
     * Creates a form to delete a equipe entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('equipe_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
