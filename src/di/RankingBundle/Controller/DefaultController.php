<?php

namespace di\RankingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="di_index")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $rank = $em->getRepository('diRankingBundle:classement')->getCurrentRanking();
        
        return $this->render('diRankingBundle:Default:index.html.twig', array('rank' => $rank));
        
    }
    
    /**
     * @Route("/dashboard/", name="di_dashboard")
     * @Secure(roles="ROLE_USER")
     * @Template()
     */
    public function dashboardAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	 
    	if ($this->get('security.context')->isGranted('ROLE_ADMIN'))
    	{
    		$admin = 'yes';
    		return $this->container->get('templating')->renderResponse('diRankingBundle:Default:dashboard.html.twig', array($admin));
    	}
    	else
    	{
    		$admin = 'no';
    		return $this->container->get('templating')->renderResponse('diRankingBundle:Default:dashboard.html.twig', array($admin));
    	}
    }
}
