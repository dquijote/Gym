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
 * @ORM\Entity(repositoryClass = "Gatorno\FrontedBundle\Repository\ServiceRepository")
 */
class Service {

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
       return $this->service;
    }


    /**
     * Customer that receive the service
     * @ORM\ManyToOne(targetEntity="Gatorno\FrontedBundle\Entity\Cliente")
     */
    private $cliente;

    /**
     * Name of the service
     * @ORM\Column(type="string")
     */
    private $service;

    /**
     * Cost of service
     * @ORM\Column(type="integer")
     */
    private $cost;

    /**
     * Worker that provide the service
     * @ORM\ManyToMany(targetEntity="Gatorno\FrontedBundle\Entity\Trabajador")
     */
    private $worker;

    /**
     * Supply to service
     * @ORM\ManyToMany(targetEntity="Gatorno\FrontedBundle\Entity\Supply")
     */
    private $supply;

    public function __construct()
    {
        $this->supply = new ArrayCollection();
        $this->worker = new ArrayCollection();
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
     * Set cliente
     *
     * @param \Gatorno\FrontedBundle\Entity\Cliente $cliente
     * @return \Gatorno\FrontedBundle\Entity\Cliente
     */
    public function setCliente(Cliente $cliente = null)
    {
        $this->cliente = $cliente;

        return $this->getCliente();
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
     * Get Service
     * @return string
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * Set Service
     * @param string $service
     * @return string
     */
    public function setService($service)
    {
        $this->service = $service;
        return $this;

    }

    /**
     * Get Cost
     * @return integer
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * Set Cost
     * @param integer $cost
     * @return integer
     */
    public function setCost($cost)
    {
       return $this->cost = $cost;

    }

    /**
     * Set Worker
     *
     * @param \Gatorno\FrontedBundle\Entity\Trabajador $worker
     * @return Trabajador
     */
    public function setWorker(Trabajador $worker = null)
    {
        $this->worker = $worker;

        return $this->getWorker();
    }

    /**
     * Get worker
     *
     * @return \Gatorno\FrontedBundle\Entity\Trabajador
     */
    public function getWorker()
    {
        return $this->worker;
    }

    /**
     * Add worker
     *
     * @param \Gatorno\FrontedBundle\Entity\Trabajador $worker
     * @return Service
     */
    public function addWorker(\Gatorno\FrontedBundle\Entity\Trabajador $worker)
    {
        $this->worker[] = $worker;

        return $this;
    }

    /**
     * Remove worker
     *
     * @param \Gatorno\FrontedBundle\Entity\Trabajador $worker
     */
    public function removeWorker(\Gatorno\FrontedBundle\Entity\Trabajador $worker)
    {
        $this->worker->removeElement($worker);
    }

    /**
     * Add supply
     *
     * @param \Gatorno\FrontedBundle\Entity\Supply $supply
     * @return Service
     */
    public function addSupply(\Gatorno\FrontedBundle\Entity\Supply $supply)
    {
        $this->supply[] = $supply;

        return $this;
    }

    /**
     * Remove supply
     *
     * @param \Gatorno\FrontedBundle\Entity\Supply $supply
     */
    public function removeSupply(\Gatorno\FrontedBundle\Entity\Supply $supply)
    {
        $this->supply->removeElement($supply);
    }

    /**
     * Get supply
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSupply()
    {
        return $this->supply;
    }
}
