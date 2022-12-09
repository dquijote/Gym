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
 * Date: 05/12/2022
 * Time: 10:41 pm
 */


namespace Gatorno\FrontedBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This service is to customer and is do for a worker
 * @ORM\Entity
 *
 */
//@ORM\Table()
class ServCliente {

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Gatorno\FrontedBundle\Entity\Service")
     */
    private $service;

    /**
     * Customer that receive the service
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Gatorno\FrontedBundle\Entity\Cliente")
     */
    private $cliente;

    /**
     * Date of beginning
     * @ORM\Column(type="datetime")
     */
    private $dateStart;
    /**
     * Date of pay
     * @ORM\Column(type="datetime")
     */
    private $datePay;


    /**
     * Set dateStart
     *
     * @param \DateTime $dateStart
     * @return ServCliente
     */
    public function setDateStart($dateStart)
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    /**
     * Get dateStart
     *
     * @return \DateTime 
     */
    public function getDateStart()
    {
        return $this->dateStart;
    }

    /**
     * Set datePay
     *
     * @param \DateTime $datePay
     * @return ServCliente
     */
    public function setDatePay($datePay)
    {
        $this->datePay = $datePay;

        return $this;
    }

    /**
     * Get datePay
     *
     * @return \DateTime 
     */
    public function getDatePay()
    {
        return $this->datePay;
    }

    /**
     * Set service
     *
     * @param \Gatorno\FrontedBundle\Entity\Service $service
     * @return ServCliente
     */
    public function setService(\Gatorno\FrontedBundle\Entity\Service $service)
    {
        $this->service = $service;

        return $this;
    }

    /**
     * Get service
     *
     * @return \Gatorno\FrontedBundle\Entity\Service 
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * Set cliente
     *
     * @param \Gatorno\FrontedBundle\Entity\Cliente $cliente
     * @return ServCliente
     */
    public function setCliente(\Gatorno\FrontedBundle\Entity\Cliente $cliente)
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
}
