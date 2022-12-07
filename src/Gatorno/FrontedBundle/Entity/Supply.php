<?php
/**
 * Created by PhpStorm.
 * User: Instructores
 * Date: 8/12/15
 * Time: 15:48
 */
/**
 * Created by PhpStorm.
 * User: Fernando
 * Date: 03/12/2022
 * Time: 11:55 am
 */


namespace Gatorno\FrontedBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * This service is to customer and is do for a worker
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass = "Gatorno\FrontedBundle\Repository\SuppyRepository")
 */
class Supply {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Name to show
     */
    public function __toString()
    {
       return $this->supplyName;
    }


    /**
     * Provider of supply
     * @ORM\ManyToMany(targetEntity="Gatorno\FrontedBundle\Entity\Provider")
     */
    private $provider;

    /**
     *
     * @ORM\Column(type="string")
     */
    private $supplyName;

    /**
     * Cost of supply
     * @ORM\Column(type="float")
     */
    private $cost;

    /**
     * Amount of supply
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * Unit of measurement // unidad de medidas
     * @ORM\ManyToOne(targetEntity="Gatorno\FrontedBundle\Entity\Unit")
     */
    private $unit;

    public function __construct()
    {
        $this->provider = new ArrayCollection();
    }


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
     * Set supplyName
     *
     * @param string $supplyName
     * @return Supply
     */
    public function setSupplyName($supplyName)
    {
        $this->supplyName = $supplyName;

        return $this;
    }

    /**
     * Get supplyName
     *
     * @return string 
     */
    public function getSupplyName()
    {
        return $this->supplyName;
    }

    /**
     * Set cost
     *
     * @param float $cost
     * @return Supply
     */
    public function setCost($cost)
    {
        $this->cost = $cost;

        return $this;
    }

    /**
     * Get cost
     *
     * @return float 
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * Set amount
     *
     * @param float $amount
     * @return Supply
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return float 
     */
    public function getAmount()
    {
        return $this->amount;
    }


    /**
     * Add provider
     *
     * @param \Gatorno\FrontedBundle\Entity\Provider $provider
     * @return Supply
     */
    public function addProvider(\Gatorno\FrontedBundle\Entity\Provider $provider)
    {
        $this->provider[] = $provider;

        return $this;
    }

    /**
     * Remove provider
     *
     * @param \Gatorno\FrontedBundle\Entity\Provider $provider
     */
    public function removeProvider(\Gatorno\FrontedBundle\Entity\Provider $provider)
    {
        $this->provider->removeElement($provider);
    }

    /**
     * Get provider
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * Set unit
     *
     * @param \Gatorno\FrontedBundle\Entity\Unit $unit
     * @return Supply
     */
    public function setUnit(\Gatorno\FrontedBundle\Entity\Unit $unit = null)
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * Get unit
     *
     * @return \Gatorno\FrontedBundle\Entity\Unit 
     */
    public function getUnit()
    {
        return $this->unit;
    }
}
