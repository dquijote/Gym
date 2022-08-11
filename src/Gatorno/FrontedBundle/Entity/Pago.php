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
 * @ORM\Entity(repositoryClass = "Gatorno\FrontedBundle\Repository\PagoRepository")
 */
class Pago {

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
    private $fechaDePago;

    /**
     *@ORM\Column(type="boolean")
     */
    private $pagado;


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
     * @return Pago
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
     * Get pagado
     *
     * @return \bool 
     */
    public function getPagado()
    {
        return $this->pagado;
    }

    /**
     * Set cliente
     *
     * @param \Gatorno\FrontedBundle\Entity\Cliente $cliente
     * @return Pago
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

    /**
     * Set pagado
     *
     * @param boolean $pagado
     * @return Pago
     */
    public function setPagado($pagado)
    {
        $this->pagado = $pagado;

        return $this;
    }
}
