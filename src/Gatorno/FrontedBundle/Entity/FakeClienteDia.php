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
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 *
 *
 * @ORM\Table()
 * @ORM\Entity()
 *
 */
class FakeClienteDia {
    //

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
    private $ClienteDiaMax;

    /**
     *@ORM\Column(type="integer")
     */
    private $ClienteDiaMin;

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
     * Set ClienteDiaMax
     *
     * @param integer $clienteDiaMax
     * @return FakeClienteDia
     */
    public function setClienteDiaMax($clienteDiaMax)
    {
        $this->ClienteDiaMax = $clienteDiaMax;

        return $this;
    }

    /**
     * Get ClienteDiaMax
     *
     * @return integer 
     */
    public function getClienteDiaMax()
    {
        return $this->ClienteDiaMax;
    }

    /**
     * Set ClienteDiaMin
     *
     * @param integer $clienteDiaMin
     * @return FakeClienteDia
     */
    public function setClienteDiaMin($clienteDiaMin)
    {
        $this->ClienteDiaMin = $clienteDiaMin;

        return $this;
    }

    /**
     * Get ClienteDiaMin
     *
     * @return integer 
     */
    public function getClienteDiaMin()
    {
        return $this->ClienteDiaMin;
    }

    /**
     * Set porciento
     *
     * @param boolean $porciento
     * @return FakeClienteDia
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
     *
     * @Assert\True(message = "mensaje")
     */
    public function isMayorQue()
    {
//        if($this->getClienteDiaMax() < $this->getClienteDiaMin())
//          $context->buildViolation('El Límite Máximo debe ser mayor que el Límite Mínimo')->atPath('ClienteDiaMax')->addViolation();
        return $this->getClienteDiaMax() > $this->getClienteDiaMin();


    }
}
