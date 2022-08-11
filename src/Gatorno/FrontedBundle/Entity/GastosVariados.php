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
 * @ORM\Entity(repositoryClass = "Gatorno\FrontedBundle\Repository\GastosVariadosRepository")
 */
class GastosVariados {

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
    private $fecha;

    /**
     *
     *@ORM\Column(type="integer")
     */
    private $monto;

    /**
     *
     *@ORM\Column(type="string")
     */
    private $montivo;




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
     * @return GastosVariados
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
     * Set monto
     *
     * @param integer $monto
     * @return GastosVariados
     */
    public function setMonto($monto)
    {
        $this->monto = $monto;

        return $this;
    }

    /**
     * Get monto
     *
     * @return integer 
     */
    public function getMonto()
    {
        return $this->monto;
    }

    /**
     * Set montivo
     *
     * @param string $montivo
     * @return GastosVariados
     */
    public function setMontivo($montivo)
    {
        $this->montivo = $montivo;

        return $this;
    }

    /**
     * Get montivo
     *
     * @return string
     */
    public function getMontivo()
    {
        return $this->montivo;
    }

    /**
     * Set trabajador
     *
     * @param \Gatorno\FrontedBundle\Entity\Trabajador $trabajador
     * @return GastosVariados
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
}
