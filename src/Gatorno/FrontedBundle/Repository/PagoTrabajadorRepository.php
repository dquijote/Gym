<?php
/**
 * Created by PhpStorm.
 * User: MaiteFelipe
 * Date: 20/09/15
 * Time: 1:35
 */

namespace Gatorno\FrontedBundle\Repository;

use Doctrine\ORM\EntityRepository;



class PagoTrabajadorRepository  extends EntityRepository{

    public function findPagoUpdate($pago)
    {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('
                        UPDATE FrontedBundle:Cliente c SET c.fechaDePago = :pago');
        $consulta->setParameters(array(
            'pago' => $pago,
        ));

        return $consulta->getResult();
    }

    public function findUpdateFechaDePago($id, $fechaDePago)
    {
        $em = $this->getEntityManager();
        $consulta1 = $em->createQuery('UPDATE FrontedBundle:cliente c
                                        SET c.fechaDePago = :fechaDePago
                                        WHERE c.id = :id');
        /*
         *  $consulta = $em->createQuery('
                        SELECT l FROM userBundle:loteria l
                        WHERE l.horario = :horario
                        AND l.fecha < :fecha');
         */

        $consulta1->setParameters(array(
            'id' => $id,
            'fechaDePago' => $fechaDePago,

        ));


        return $consulta1->getResult();
       // UPDATE OfertaBundle:Oferta o SET o.precio = o.precio * 1.10
    }

    public function findUpdateReincorporacion($id,$nombre,$apellidos,$fechaDePago,$tipo,$servicio,$costoDeservicio)
    {
        $em = $this->getEntityManager();
        $consulta1 = $em->createQuery('UPDATE FrontedBundle:cliente c
                                        SET c.fechaDePago = :fechaDePago,
                                        c.nombre = :nombre,
                                        c.apellidos = :apellidos,
                                        c.tipo = :tipo,
                                        c.servicio = :servicio,
                                        c.costoDeservicio = :costoDeservicio
                                        WHERE c.id = :id');
        /*
         *  $consulta = $em->createQuery('
                        SELECT l FROM userBundle:loteria l
                        WHERE l.horario = :horario
                        AND l.fecha < :fecha');
         */

        $consulta1->setParameters(array(
            'id' => $id,
            'fechaDePago' => $fechaDePago,
            'nombre'=> $nombre,
            'apellidos'=> $apellidos,
            'tipo'=> $tipo,
            'servicio'=> $servicio,
            'costoDeservicio'=> $costoDeservicio,

        ));


        return $consulta1->getResult();
        // UPDATE OfertaBundle:Oferta o SET o.precio = o.precio * 1.10
    }
	
	  public function findFiltroFecha($fechaInicial,$fechaFinal)
    {
        $em = $this->getEntityManager();

        $consulta = $em->createQuery('SELECT c FROM FrontedBundle:PagoTrabajador c WHERE
        c.fechaDePago >= :fechaInicial AND
        c.fechaDePago <= :fechaFinal ORDER BY c.fechaDePago ASC');

        $consulta->setParameters(array(
            'fechaInicial' => $fechaInicial,
            'fechaFinal' => $fechaFinal
        ));

        $oferta = $consulta->getResult();

        return $oferta;


    }

    public function findFechaDePago($fechaInicial,$fechaFinal)
    {
        $em = $this->getEntityManager();

        $consulta = $em->createQuery('SELECT c FROM FrontedBundle:Cliente c WHERE
        c.fechaDePago >= :fechaInicial AND
        c.fechaDePago <= :fechaFinal ORDER BY c.fechaDePago ASC');

        $consulta->setParameters(array(
            'fechaInicial' => $fechaInicial,
            'fechaFinal' => $fechaFinal
        ));

        $oferta = $consulta->getResult();

        return $oferta;


    }

} 