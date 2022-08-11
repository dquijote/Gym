<?php
/**
 * Created by PhpStorm.
 * User: Instructores
 * Date: 8/12/15
 * Time: 15:48
 */
/**
 * Created by PhpStorm.
 * User: MaiteFelipe
 * Date: 24/09/15
 * Time: 18:45
 */


namespace Gatorno\FrontedBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass = "Gatorno\FrontedBundle\Repository\VisitaRepository")
 */
class Visita {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    public function __toString()
    {
       return '' ;
    }


    /**
     *
     * @ORM\ManyToOne(targetEntity="Gatorno\FrontedBundle\Entity\Cliente")
     */
    private $cliente;

    /**
     *
     *@ORM\Column(type="date")
     */
    private $fecha;

    /**
     *@ORM\Column(type="time")
     */
    private $hora;


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
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Visita
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime 
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set hora
     *
     * @param \DateTime $hora
     * @return Visita
     */
    public function setHora($hora)
    {
        $this->hora = $hora;

        return $this;
    }

    /**
     * Get hora
     *
     * @return \DateTime 
     */
    public function getHora()
    {
        return $this->hora;
    }

    /**
     * Set cliente
     *
     * @param \Gatorno\FrontedBundle\Entity\Cliente $cliente
     * @return Visita
     */
    public function setCliente(\Gatorno\FrontedBundle\Entity\Cliente $cliente = null)
    {
        $this->cliente = $cliente;

        return $this;
    }

    /**
     * Get cliente
     *
     * @return \Gatorno\FrontedBundle\Entity\Cliente 
     */
    public function getCliente()
    {
        return $this->cliente;
    }
}
