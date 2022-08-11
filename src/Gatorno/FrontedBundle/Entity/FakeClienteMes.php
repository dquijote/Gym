<?php
/**
 * Created by PhpStorm.
 * User: MaiteFelipe
 * Date: 24/09/15
 * Time: 18:45
 */


namespace Gatorno\FrontedBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ExecutionContext;


/**
 *
 *
 * @ORM\Table()
 * @ORM\Entity()
 * @Assert\Callback(methods={"isMayorQue"})
 */
class FakeClienteMes {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     *@ORM\Column(type="integer")
     */
    private $ClienteMesMax;

    /**
     *@ORM\Column(type="integer")
     */
    private $ClienteMesMin;

    /**
     *@ORM\Column(type="integer")
     */
    private $LimClienteDia;

    /**
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
     * Set ClienteMesMax
     *
     * @param integer $clienteMesMax
     * @return FakeClienteMes
     */
    public function setClienteMesMax($clienteMesMax)
    {
        $this->ClienteMesMax = $clienteMesMax;

        return $this;
    }

    /**
     * Get ClienteMesMax
     *
     * @return integer 
     */
    public function getClienteMesMax()
    {
        return $this->ClienteMesMax;
    }

    /**
     * Set ClienteMesMin
     *
     * @param integer $clienteMesMin
     * @return FakeClienteMes
     */
    public function setClienteMesMin($clienteMesMin)
    {
        $this->ClienteMesMin = $clienteMesMin;

        return $this;
    }

    /**
     * Get ClienteMesMin
     *
     * @return integer 
     */
    public function getClienteMesMin()
    {
        return $this->ClienteMesMin;
    }

    /**
     * Set porciento
     *
     * @param boolean $porciento
     * @return FakeClienteMes
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

    /**
     * Set LimClienteDia
     *
     * @param integer $limClienteDia
     * @return FakeClienteMes
     */
    public function setLimClienteDia($limClienteDia)
    {
        $this->LimClienteDia = $limClienteDia;

        return $this;
    }

    /**
     * Get LimClienteDia
     *
     * @return integer 
     */
    public function getLimClienteDia()
    {
        return $this->LimClienteDia;
    }

    //---------------------------------------------------
    //---------------VALIDACIONES------------------------
    //---------------------------------------------------

    /**
     *
     *
     */
    public function isMayorQue(ExecutionContext $context)
    {
        if($this->getClienteMesMax() < $this->getClienteMesMin())
          $context->addViolationAt('ClienteMesMin', 'El Límite Mínimo tiene un valor superior al Límite Máximo ',
              array(), null);

        if($this->getClienteMesMax() < $this->getClienteMesMin())
            $context->addViolationAt('ClienteMesMax', 'El Límite Máximo tiene un valor inferior al Límite Mínimo ',
                array(), null);
        //return $this->getClienteDiaMax() > $this->getClienteDiaMin();


    }
}
