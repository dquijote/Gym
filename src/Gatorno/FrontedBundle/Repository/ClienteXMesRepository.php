<?php
/**
 * Created by PhpStorm.
 * User: MaiteFelipe
 * Date: 20/09/15
 * Time: 1:35
 */

namespace Gatorno\FrontedBundle\Repository;

use Doctrine\ORM\EntityRepository;
//use atis\userBundle\Entity;


class ClienteXMesRepository  extends EntityRepository{



	/*
	 * Busca los clientes ingresados en un rango de fecha.
	 * */
	  public function findFiltroFecha($fechaInicial,$fechaFinal)
    {
        $em = $this->getEntityManager();

        $consulta = $em->createQuery('SELECT c FROM FrontedBundle:Cliente c WHERE
        c.fechaDeIngreso >= :fechaInicial AND
        c.fechaDeIngreso <= :fechaFinal ORDER BY c.fechaDeIngreso ASC');

        $consulta->setParameters(array(
            'fechaInicial' => $fechaInicial,
            'fechaFinal' => $fechaFinal
        ));

        $oferta = $consulta->getResult();

        return $oferta;


    }

    /*
     * Buscar los meses que corresponden al intervalo de dias pasado por parametros
     * */
    public function findAnnoClienteXMes($fechaInicial, $fechaFinal)
    {
        $em = $this->getEntityManager();

        $consulta = $em->createQuery('SELECT c FROM FrontedBundle:ClienteXMes c WHERE
        c.Mes >= :fechaInicial AND
        c.Mes <= :fechaFinal ORDER BY c.Mes ASC');

        $consulta->setParameters(array(
            'fechaInicial' => $fechaInicial,
            'fechaFinal' => $fechaFinal
        ));

        $oferta = $consulta->getResult();

        return $oferta;
    }

} 