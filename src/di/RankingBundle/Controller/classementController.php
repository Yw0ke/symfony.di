<?php

namespace di\RankingBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use di\RankingBundle\Entity\classement;
use di\RankingBundle\Form\classementType;
use di\RankingBundle\Form\resultsType;
/**
 * classement controller.
 *
 * @Route("/classement")
 */
class classementController extends Controller
{
	/**
	 * Lists all classement entities.
	 *
	 * @Route("/", name="classement")
	 * @Secure(roles="ROLE_ADMIN")
	 * @Template("")
	 */
	public function choseAction()
	{
		$em = $this->getDoctrine()->getManager();
		
		$epreuves = $em->getRepository('diRankingBundle:epreuve')->findAll();
		
		$full = array();
		
		foreach ($epreuves as $epreuve)
		{
			$classement = $em->getRepository('diRankingBundle:classement')->findOneBy(array('idEpreuve' => $epreuve->getId()));
			
			if (!$classement)
			{
				$full[$epreuve->getNom()] = false;
			}
			else 
			{
				$full[$epreuve->getNom()] = true;
			}
		}
		
		return array(
				'entities' => $epreuves,
				'full' => $full
		);
	}
	
    /**
     * Lists all classement entities.
     *
     * @Route("/chosen/{idEpreuve}", name="classement_chosen")
     * @Method("GET")
     * @Secure(roles="ROLE_ADMIN")
     * @Template("diRankingBundle:classement:index.html.twig")
     */
    public function indexAction($idEpreuve ,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        $entities = $em->getRepository('diRankingBundle:classement')->findByEpreuveOrdered($idEpreuve);
        $epreuve = $em->getRepository('diRankingBundle:epreuve')->findBy(array('id' => $idEpreuve));
        
        return array(
            'entities' => $entities,
        	'epreuve' => $epreuve[0]
        );
    }

    /**
    * Creates a form to create a classement entity.
    *
    * @param classement $entity The entity
    * 
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(classement $entity)
    {
        $form = $this->createForm(new classementType(), $entity, array(
            'action' => $this->generateUrl('classement_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }
    
    /**
     * Displays a form to create a new classement entity.
     *
     * @Route("/new", name="classementResults_new")
     * @Method("GET")
     * @Secure(roles="ROLE_ADMIN")
     * @Template()
     */
    public function newAction()
    {
    	$classement = new classement();
    	
    	$form   = $this->createCreateForm($classement);
    
    	return array(
    			'entity' => $classement,
    			'form'   => $form->createView(),
    	);
    }

    /**
     * Finds and displays a classement entity.
     *
     * @Route("/{id}", name="classement_show")
     * @Method("GET")
     * @Secure(roles="ROLE_ADMIN")
     * @Template()
     */
    public function showAction($id)
    {
    	$em = $this->getDoctrine()->getManager();
    
    	$entity = $em->getRepository('diRankingBundle:classement')->find($id);
    
    	if (!$entity) {
    		throw $this->createNotFoundException('Unable to find classement entity.');
    	}
    
    	$deleteForm = $this->createDeleteForm($id);
    
    	return array(
    			'entity'      => $entity,
    			'delete_form' => $deleteForm->createView(),
    	);
    }

    /**
     * Displays a form to edit an existing classement entity.
     *
     * @Route("/{id}/edit", name="classement_edit")
     * @Method("GET")
     * @Secure(roles="ROLE_ADMIN")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('diRankingBundle:classement')->find($id);
		
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find classement entity.');
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
    * Creates a form to edit a classement entity.
    *
    * @param classement $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(classement $entity)
    {
        $form = $this->createForm(new classementType(), $entity, array(
            'action' => $this->generateUrl('classement_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing classement entity.
     *
     * @Route("/{id}", name="classement_update")
     * @Method("PUT")
     * @Secure(roles="ROLE_ADMIN")
     * @Template("diRankingBundle:classement:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('diRankingBundle:classement')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find classement entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('classement_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a classement entity.
     *
     * @Route("/{id}", name="classement_delete")
     * @Method("DELETE")
     * @Secure(roles="ROLE_ADMIN")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('diRankingBundle:classement')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find classement entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('di_dashboard'));
    }

    /**
     * Creates a form to delete a classement entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('classement_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    
    /**
     * @Route("/newResults/{idEpreuve}", name="di_newResults")
     * @Secure(roles="ROLE_ADMIN")
     * @Template()
     */
    public function newResultsAction($idEpreuve, Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
    	
    	$epreuve = $em->getRepository('diRankingBundle:epreuve')->findBy(array('id' => $idEpreuve));
    	$equipes = $em->getRepository('diRankingBundle:equipe')->findAll();
    	
    	$classements = array();
    	foreach ($equipes as $equipe)
    	{
    		$class = new classement();
    		$class->setIdEpreuve($epreuve[0]);
    		$class->setIdEquipe($equipe);
    		$classements[] = $class;
    	}
    	
    	$form = $this->createForm(new resultsType(), $classements); //, $adsParameter
    
    	$form->handleRequest($request);
    
    	if ($form->isValid())
    	{	
    		$data = $form->getData();
    		
    		$freshData = array();
    		
    		foreach ($data as $classement)
    		{
    			if (is_object($classement) && $classement instanceof classement)
    			{
    				$classement->setPosition($data['position'.$classement->getIdEquipe()->getNom()]);
    				$classement->setPoints($data['points'.$classement->getIdEquipe()->getNom()]);
					
	    			$em->persist($classement);
    			}
    		}   		
    		
    		$em->flush();
    				
    		return $this->redirect($this->generateUrl('classement_chosen', array('idEpreuve' => $idEpreuve)));
    	}
    
    	return $this->render('diRankingBundle:classement:new.html.twig', array ('form' => $form->createView()));
    }
    
    /**
     * @Route("/edit/{idEpreuve}", name="classement_edit")
     */
    public function classementEditAction(Request $request, $idEpreuve)
    {
    	$em = $this->getDoctrine()->getManager();
    
    	$epreuve = $em->getRepository("diRankingBundle:epreuve")->findOneBy(array('id' => $idEpreuve));
    	$classements = $em->getRepository("diRankingBundle:classement")->findBy(array('idEpreuve' => $epreuve));
    	
    	if (!$classements)
    	{
    		$this->redirect($this->generateUrl('di_newResults', array('idEpreuve' => $idEpreuve)));
    	}
    	
    	$form = $this->createForm(new resultsType(), $classements);
    	
    	$form->handleRequest($request);
    
    	if ($form->isValid()) {
    		
    		$data = $form->getData();
    		
    		$freshData = array();
    		
    		foreach ($data as $classement)
    		{
    			if (is_object($classement) && $classement instanceof classement)
    			{
	    			$classement->setPosition($data['position'.$classement->getIdEquipe()->getNom()]);
	    			$classement->setPoints($data['points'.$classement->getIdEquipe()->getNom()]);

	    			$em->persist($classement);
    			}
    		}   		
    		
    		$em->flush();
    
    		return $this->redirect($this->generateUrl('classement_chosen', array('idEpreuve' => $idEpreuve)));
    	}
    	
    	return $this->render('diRankingBundle:classement:edit.html.twig', array ('form' => $form->createView(),
    																			 'epreuve' => $epreuve));
    }
    
}
