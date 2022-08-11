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
 * @ORM\Entity(repositoryClass = "Gatorno\FrontedBundle\Repository\PagoTrabajadorRepository")
 */
class PagoTrabajador {

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
     * @ORM\ManyToOne(targetEntity="Gatorno\FrontedBundle\Entity\Trabajador")
     */
    private $trabajador;

    /**
     *
     *@ORM\Column(type="date")
     */
    private $fechaDePago;

    /**
     *
     *@ORM\Column(type="integer")
     */
    private $salario;


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
     * Set fechaDePago
     *
     * @param \DateTime $fechaDePago
     * @return PagoTrabajador
     */
    public function setFechaDePago($fechaDePago)
    {
        $this->fechaDePago = $fechaDePago;

        return $this;
    }

    /**
     * Get fechaDePago
     *
     * @return \DateTime 
     */
    public function getFechaDePago()
    {
        return $this->fechaDePago;
    }




    /**
     * Set trabajador
     *
     * @param \Gatorno\FrontedBundle\Entity\Trabajador $trabajador
     * @return PagoTrabajador
     */
    public function setTrabajador(\Gatorno\FrontedBundle\Entity\Trabajador $trabajador = null)
    {
        $this->trabajador = $trabajador;

        return $this;
    }

    /**
     * Get trabajador
     *
     * @return \Gatorno\FrontedBundle\Entity\Trabajador 
     */
    public function getTrabajador()
    {
        return $this->trabajador;
    }

    /**
     * Set salario
     *
     * @param integer $salario
     * @return PagoTrabajador
     */
    public function setSalario($salario)
    {
        $this->salario = $salario;

        return $this;
    }

    /**
     * Get salario
     *
     * @return integer 
     */
    public function getSalario()
    {
        return $this->salario;
    }
}
