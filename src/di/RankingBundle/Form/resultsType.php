<?php

namespace di\RankingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class resultsType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	foreach ($options['data'] as $classement)
    	{
    		
    		$builder->add('position'.$classement->getIdEquipe()->getNom(), 'integer', array('label' => 'Position :',
    																						'data' => $classement->getPosition()))
		            ->add('points'.$classement->getIdEquipe()->getNom(), 'integer', array('label' => 'Points :',
    																						'data' => $classement->getPoints()))
		            ->add('idEquipe'.$classement->getIdEquipe()->getNom(), 'entity', array('label' => 'Equipe :',
											            								   'class' => 'diRankingBundle:equipe',
											    										   'property' => 'nom',
		            																	   'data' => $classement->getIdEquipe(),
		            																	   'read_only' => true))
		            ->add('idEpreuve'.$classement->getIdEquipe()->getNom(), 'entity', array('label' => 'Epreuve :',
											            								    'class' => 'diRankingBundle:epreuve',
											    										    'property' => 'nom',
    																						'data' => $classement->getIdEpreuve(),
		            																		'read_only' => true));
    	}
    	
       $builder->add('Envoyer', 'submit');
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => null,
        	'cascade_validation' => true
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'di_rankingbundle_classement';
    }
}
