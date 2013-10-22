<?php
namespace di\UserBundle\DataFixtures\ORM;

use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use di\UserBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\EntityManager;

class LoadUserData implements FixtureInterface, ContainerAwareInterface
{
	private $container;

	public function setContainer(ContainerInterface $container = null)
	{
		$this->container = $container;
	}

	public function load(ObjectManager $manager)
	{
		$userManager = $this->container->get('fos_user.user_manager');
		
		$userAdmin = $userManager->createUser();
		$userUser = $userManager->createUser();
		
		$encoder = $this->container
						->get('security.encoder_factory')
						->getEncoder($userAdmin);
		
		//Enregistrement de l'admin
		$userAdmin->setUsername('admin');
		$userAdmin->setPassword($encoder
				  ->encodePassword('admin', $userAdmin->getSalt()));
		$userAdmin->setEmail('admin@admin.com');
		$userAdmin->setEnabled(true);
		$userAdmin->setRoles(array('ROLE_ADMIN'));
		$userManager->updateUser($userAdmin, true);
		
		//Enregistrement de user
		$userUser->setUsername('user');
		$userUser->setPassword($encoder
            	  ->encodePassword('user', $userUser->getSalt()));
		$userUser->setEmail('user@user.com');
		$userUser->setEnabled(true);
		$userUser->setRoles(array('ROLE_USER'));
		$userManager->updateUser($userUser, true);
	}
}