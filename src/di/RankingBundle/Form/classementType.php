<?php

namespace di\RankingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class classementType extends AbstractType
{
	private static $incremental = 1;
	
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('position', 'integer', array('label' => 'Position :'))
            ->add('points', 'integer', array('label' => 'Points :'))
            ->add('idEquipe', 'entity', array('label' => 'Equipe :',
            								  'class' => 'diRankingBundle:equipe',
    										  'property' => 'nom',))
            ->add('idEpreuve', 'entity', array('label' => 'Epreuve :',
            								  'class' => 'diRankingBundle:epreuve',
    										  'property' => 'nom',))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'di\RankingBundle\Entity\classement',
        	'cascade_validation' => true
        ));
    }

    /**
     * @return string
     */
	public function getName() {
        return 'your_form_'.self::$incremental++;
    }
}
