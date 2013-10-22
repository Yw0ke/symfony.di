<?php
namespace di\RankingBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\EntityManager;
use di\RankingBundle\Entity\classement;

class LoadClassementData implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
	private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
    
	public function load(ObjectManager $manager)
	{
		$manager = $this->container->get('doctrine')->getManager();
		
		//Récuperation des équipes
		$qb = $manager->createQueryBuilder();
		$qb->addSelect('eq');
		$qb->from('diRankingBundle:equipe','eq');
		$eq = $qb->getQuery()->getResult();
		
		//Récuperation des équipes
		$qb = $manager->createQueryBuilder();
		$qb->addSelect('ep');
		$qb->from('diRankingBundle:epreuve','ep');
		$ep = $qb->getQuery()->getResult();
		
		foreach ($ep as $epreuve)	//Pour chaque épreuve
		{
			$calcul = array('8','6', '4', '3', '2', '1', '0', '0');	//Points a attribuer
			shuffle($calcul);
			
			foreach ($eq as $equipe)	//Pour chaque équipe
			{
				$count = count($calcul)-1;
				$points = $calcul[$count];
				
				$classement = new classement();
				$classement->setIdEpreuve($epreuve);
				$classement->setIdEquipe($equipe);
				$classement->setPoints($points);
				
				switch ($points) {
					case 8:
						$classement->setPosition(1);
						break;
					case 6:
						$classement->setPosition(2);
						break;
					case 4:
						$classement->setPosition(3);
						break;
					case 3:
						$classement->setPosition(4);
						break;
					case 2:
						$classement->setPosition(5);
						break;
					case 1:
						$classement->setPosition(6);
						break;
					case 0:
						$classement->setPosition(7);
						break;
				}
				
				array_pop($calcul);
				$manager->persist($classement);
			}
		}
		
		$manager->flush();
	}
	
	public function getOrder()
	{
		return 3;
	}
}