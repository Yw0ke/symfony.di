<?php

namespace di\RankingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * classement
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="di\RankingBundle\Entity\Repository\classementRepository")
 */
class classement
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="di\RankingBundle\Entity\equipe", cascade={"persist"})
     * @ORM\JoinColumn(name="id_equipe", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $idEquipe;

       /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="di\RankingBundle\Entity\epreuve", cascade={"persist"})
     * @ORM\JoinColumn(name="id_epreuve", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $idEpreuve;

    /**
     * @var integer
     *
     * @ORM\Column(name="position", type="integer")
     */
    private $position;

    /**
     * @var integer
     *
     * @ORM\Column(name="points", type="integer")
     */
    private $points;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idEquipe
     *
     * @param integer $idEquipe
     * @return classement
     */
    public function setIdEquipe($idEquipe)
    {
        $this->idEquipe = $idEquipe;
    
        return $this;
    }

    /**
     * Get idEquipe
     *
     * @return integer 
     */
    public function getIdEquipe()
    {
        return $this->idEquipe;
    }

    /**
     * Set idEpreuve
     *
     * @param integer $idEpreuve
     * @return classement
     */
    public function setIdEpreuve($idEpreuve)
    {
        $this->idEpreuve = $idEpreuve;
    
        return $this;
    }

    /**
     * Get idEpreuve
     *
     * @return integer 
     */
    public function getIdEpreuve()
    {
        return $this->idEpreuve;
    }

    /**
     * Set position
     *
     * @param integer $position
     * @return classement
     */
    public function setPosition($position)
    {
        $this->position = $position;
    
        return $this;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set points
     *
     * @param integer $points
     * @return classement
     */
    public function setPoints($points)
    {
        $this->points = $points;
    
        return $this;
    }

    /**
     * Get points
     *
     * @return integer 
     */
    public function getPoints()
    {
        return $this->points;
    }
}
