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
 * @ORM\Entity(repositoryClass = "Gatorno\FrontedBundle\Repository\TareaRepository")
 */
class Tarea {

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
     * @ORM\Column(type="string")
     */
    private $nombre;

    /**
     *
     * @ORM\Column(type="string")
     */
    private $descripcion;

    /**
     *
     *@ORM\Column(type="date")
     */
    private $fechaDeCreada;

    /**
     *
     *@ORM\Column(type="date")
     */
    private $fechaDeCumplimiento;

    /**
     *@ORM\ManyToOne(targetEntity="Gatorno\FrontedBundle\Entity\Trabajador")
     */
    private $asignadaToTrabajador;
    /**
     *@ORM\Column( type="string")
     */
    private $creadaPor;

    /**
     *@ORM\Column( type="boolean")
     */
    private $cumplida;

    
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
     * Set nombre
     *
     * @param string $nombre
     * @return Tarea
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Tarea
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set fechaDeCreada
     *
     * @param \DateTime $fechaDeCreada
     * @return Tarea
     */
    public function setFechaDeCreada($fechaDeCreada)
    {
        $this->fechaDeCreada = $fechaDeCreada;

        return $this;
    }

    /**
     * Get fechaDeCreada
     *
     * @return \DateTime 
     */
    public function getFechaDeCreada()
    {
        return $this->fechaDeCreada;
    }

    /**
     * Set fechaDeCumplimiento
     *
     * @param \DateTime $fechaDeCumplimiento
     * @return Tarea
     */
    public function setFechaDeCumplimiento($fechaDeCumplimiento)
    {
        $this->fechaDeCumplimiento = $fechaDeCumplimiento;

        return $this;
    }

    /**
     * Get fechaDeCumplimiento
     *
     * @return \DateTime 
     */
    public function getFechaDeCumplimiento()
    {
        return $this->fechaDeCumplimiento;
    }

    /**
     * Set creadaPor
     *
     * @param string $creadaPor
     * @return Tarea
     */
    public function setCreadaPor($creadaPor)
    {
        $this->creadaPor = $creadaPor;

        return $this;
    }

    /**
     * Get creadaPor
     *
     * @return string 
     */
    public function getCreadaPor()
    {
        return $this->creadaPor;
    }

    /**
     * Set asignadaToTrabajador
     *
     * @param \Gatorno\FrontedBundle\Entity\Trabajador $asignadaToTrabajador
     * @return Tarea
     */
    public function setAsignadaToTrabajador(\Gatorno\FrontedBundle\Entity\Trabajador $asignadaToTrabajador = null)
    {
        $this->asignadaToTrabajador = $asignadaToTrabajador;

        return $this;
    }

    /**
     * Get asignadaToTrabajador
     *
     * @return \Gatorno\FrontedBundle\Entity\Trabajador 
     */
    public function getAsignadaToTrabajador()
    {
        return $this->asignadaToTrabajador;
    }

    /**
     * Set cumplida
     *
     * @param boolean $cumplida
     * @return Tarea
     */
    public function setCumplida($cumplida)
    {
        $this->cumplida = $cumplida;

        return $this;
    }

    /**
     * Get cumplida
     *
     * @return boolean 
     */
    public function getCumplida()
    {
        return $this->cumplida;
    }
}
