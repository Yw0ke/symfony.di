<?php

namespace di\RankingBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use di\RankingBundle\Entity\epreuve;
use di\RankingBundle\Form\epreuveType;

/**
 * epreuve controller.
 *
 * @Route("/epreuve")
 */
class epreuveController extends Controller
{

    /**
     * Lists all epreuve entities.
     *
     * @Route("/", name="epreuve")
     * @Secure(roles="ROLE_ADMIN")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('diRankingBundle:epreuve')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new epreuve entity.
     *
     * @Route("/newEpreuve", name="epreuve_create")
     * @Method("POST")
     * @Secure(roles="ROLE_ADMIN")
     * @Template("diRankingBundle:epreuve:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new epreuve();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('epreuve_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a epreuve entity.
    *
    * @param epreuve $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(epreuve $entity)
    {
        $form = $this->createForm(new epreuveType(), $entity, array(
            'action' => $this->generateUrl('epreuve_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new epreuve entity.
     *
     * @Route("/new", name="epreuve_new")
     * @Method("GET")
     * @Secure(roles="ROLE_ADMIN")
     * @Template()
     */
    public function newAction()
    {
        $entity = new epreuve();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a epreuve entity.
     *
     * @Route("/{id}", name="epreuve_show")
     * @Method("GET")
     * @Secure(roles="ROLE_ADMIN")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('diRankingBundle:epreuve')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find epreuve entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing epreuve entity.
     *
     * @Route("/{id}/edit", name="epreuve_edit")
     * @Method("GET")
     * @Secure(roles="ROLE_ADMIN")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('diRankingBundle:epreuve')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find epreuve entity.');
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
    * Creates a form to edit a epreuve entity.
    *
    * @param epreuve $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(epreuve $entity)
    {
        $form = $this->createForm(new epreuveType(), $entity, array(
            'action' => $this->generateUrl('epreuve_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing epreuve entity.
     *
     * @Route("/{id}", name="epreuve_update")
     * @Method("PUT")
     * @Secure(roles="ROLE_ADMIN")
     * @Template("diRankingBundle:epreuve:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('diRankingBundle:epreuve')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find epreuve entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('epreuve_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a epreuve entity.
     *
     * @Route("/{id}", name="epreuve_delete")
     * @Method("DELETE")
     * @Secure(roles="ROLE_ADMIN")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('diRankingBundle:epreuve')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find epreuve entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('di_dashboard'));
    }

    /**
     * Creates a form to delete a epreuve entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('epreuve_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
