<?php
namespace di\RankingBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\EntityManager;
use di\RankingBundle\Entity\epreuve;

class LoadEpreuveData implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
	private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
    
	public function load(ObjectManager $manager)
	{
		$manager = $this->container->get('doctrine')->getManager();
		
		$noms = array('VTT', 'Ski de fond', 'Natation', 'Course', 'Escalade', 'Tir');
		
		foreach ($noms as $nom)
		{
			$epreuve = new epreuve();
			$epreuve->setNom($nom);
			
			$manager->persist($epreuve);
		}
		
		$manager->flush();
	}
	
	public function getOrder()
	{
		return 2;
	}
}