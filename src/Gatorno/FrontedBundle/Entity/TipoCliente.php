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
 * @ORM\Entity()
 */
class TipoCliente {

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
       return $this->getTipo();
    }




    /**
     *@ORM\Column(type="string")
     */
    private $tipo;

    /**
     *@ORM\Column(type="integer")
     */
    private $importe;


   
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
     * Set tipo
     *
     * @param string $tipo
     * @return Tipo
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Get cargo
     *
     * @return Integer
     */
    public function getImporte()
    {
        return $this->importe;
    }

    /**
     * Set importe
     *
     * @param integer $importe
     * @return importe
     */
    public function setImporte($importe)
    {
        $this->importe = $importe;

        return $this;
    }


}
