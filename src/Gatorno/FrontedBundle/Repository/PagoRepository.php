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


class PagoRepository  extends EntityRepository{

    public function findCantPagosHoy($fechaInicio, $fechaFin)
    {
        $em = $this->getEntityManager();

        $consulta = $em->createQuery('
                        SELECT p FROM FrontedBundle:Pago p WHERE
                        p.fechaDePago >= :fechaInicio  AND
                        p.fechaDePago <= :fechaFin ORDER BY p.fechaDePago ASC');
        $consulta->setParameters(
            array('fechaInicio'=>$fechaInicio,
                'fechaFin'=>$fechaFin
            )
        );

        return $consulta->getResult();
    }


    public function findUpdateEnvioGiro($id,$fecha,$envioCash,$viaje,$gastos,$viajeId)
    {
        //el viajeID hay que ver como se gestiona(actualmente no se)
        $em = $this->getEntityManager();
        $consulta1 = $em->createQuery('UPDATE userBundle:pajillasEnvioGiro g
                                        SET g.id = :id,
                                        g.fecha = :fecha,
                                        g.envioCash = :envioCash,
                                        g.viaje = :viaje,
                                        g.gastos = :gastos');
        $consulta = $em->createQuery('
                        SELECT l FROM userBundle:loteria l
                        WHERE l.horario = :horario
                        AND l.fecha < :fecha');
        $consulta1->setParameters(array(
            'id' => $id,
            'fecha' => $fecha,
            'envioCash'=> $envioCash,
            'viaje' => $viaje,
            'gastos' => $gastos
        ));
        $oferta = $consulta->getResult();

        return $oferta;
       // UPDATE OfertaBundle:Oferta o SET o.precio = o.precio * 1.10
    }
	
	  public function findFiltroFechaViaje($fechaInicial,$fechaFinal)
    {
        $em = $this->getEntityManager();

        $consulta = $em->createQuery('SELECT v FROM userBundle:pajillasViaje v WHERE
        v.fecha >= :fechaInicial AND
        v.fecha <= :fechaFinal ORDER BY v.fecha ASC');

        $consulta->setParameters(array(
            'fechaInicial' => $fechaInicial,
            'fechaFinal' => $fechaFinal
        ));

        $oferta = $consulta->getResult();

        return $oferta;


    }

} 