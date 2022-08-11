<?php
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
 * @ORM\Entity(repositoryClass = "Gatorno\FrontedBundle\Repository\ClienteXMesRepository")
 */
class ClienteXMes {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Identifica la cant de clientes que representan el mes
     *
     *@ORM\Column(type="integer")
     */
    private $ClienteXMes;

    /**
     * Identifica al mes del cual se estan guardando los valores
     *
     *@ORM\Column(type="date")
     */
    private $Mes;

    /**
     * Se guarda la fecha en que fueron insertados los valores de la tabla
     * Para mayor facilidad en la depuracion
     *
     *@ORM\Column(type="date")
     */
    private $FechaSave;

    /**
     * Identifica si el valor fue calculado porcentualmente
     * o si fue definido con valores fijo
     *
     *@ORM\Column(type="boolean")
     */
    private $porciento;


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
     * Set ClienteXMes
     *
     * @param integer $clienteXMes
     * @return ClienteXMes
     */
    public function setClienteXMes($clienteXMes)
    {
        $this->ClienteXMes = $clienteXMes;

        return $this;
    }

    /**
     * Get ClienteXMes
     *
     * @return integer 
     */
    public function getClienteXMes()
    {
        return $this->ClienteXMes;
    }

    /**
     * Set Mes
     *
     * @param \DateTime $mes
     * @return ClienteXMes
     */
    public function setMes($mes)
    {
        $this->Mes = $mes;

        return $this;
    }

    /**
     * Get Mes
     *
     * @return \DateTime 
     */
    public function getMes()
    {
        return $this->Mes;
    }

    /**
     * Set FechaSave
     *
     * @param \DateTime $fechaSave
     * @return ClienteXMes
     */
    public function setFechaSave($fechaSave)
    {
        $this->FechaSave = $fechaSave;

        return $this;
    }

    /**
     * Get FechaSave
     *
     * @return \DateTime 
     */
    public function getFechaSave()
    {
        return $this->FechaSave;
    }

    /**
     * Set porciento
     *
     * @param boolean $porciento
     * @return ClienteXMes
     */
    public function setPorciento($porciento)
    {
        $this->porciento = $porciento;

        return $this;
    }

    /**
     * Get porciento
     *
     * @return boolean 
     */
    public function getPorciento()
    {
        return $this->porciento;
    }
}
