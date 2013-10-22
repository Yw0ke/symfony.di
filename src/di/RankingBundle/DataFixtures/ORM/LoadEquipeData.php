<?php
namespace di\RankingBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\EntityManager;
use di\RankingBundle\Entity\equipe;

class LoadEquipeData implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
	private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
    
	public function load(ObjectManager $manager)
	{
		$manager = $this->container->get('doctrine')->getManager();
		
		$noms = array('Paris', 'Marseille', 'Lyon', 'Monaco', 'Lille', 'Sochaux', 'Montpellier', 'Saint-Etienne');
		
		foreach ($noms as $nom)
		{
			$equipe = new equipe();
			$equipe->setNom($nom);
			
			$manager->persist($equipe);
		}
		
		$manager->flush();
	}
	
	public function getOrder()
	{
		return 1;
	}
}