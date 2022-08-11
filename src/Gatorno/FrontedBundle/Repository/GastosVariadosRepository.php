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


class GastosVariadosRepository  extends EntityRepository{

    public function findCantPagosHoy($fechaInicio, $fechaFin)
    {
        $em = $this->getEntityManager();

        $consulta = $em->createQuery('
                        SELECT p FROM FrontedBundle:GastosVariados p
                        WHERE p.fecha >= :fechaInicio
                        AND p.fecha <= :fechaFin');
        $consulta->setParameters(
            array('fechaInicio'=>$fechaInicio,
                'fechaFin'=>$fechaFin
            )
        );

        return $consulta->getResult();
    }

    public function findUpdate($id,$nombre,$fechaDeCreada,$fechaDeCumplimiento,$asignadaA,$creadaPor,$descripcion,$cumplida)
    {

        $em = $this->getEntityManager();
        $consulta1 = $em->createQuery('UPDATE FrontedBundle:Tarea t
                                        SET t.descripcion = :descripcion,
                                        t.nombre = :nombre,
                                        t.fechaDeCreada = :fechaDeCreada,
                                        t.fechaDeCumplimiento = :fechaDeCumplimiento,
                                        t.asignadaToTrabajador = :asignadaToTrabajador,
                                        t.creadaPor = :creadaPor,
                                        t.cumplida = :cumplida
                                        WHERE t.id = :id');
        $consulta = $em->createQuery('
                        SELECT l FROM FrontedBundle:Tarea l

                        ');
        $consulta1->setParameters(array(

            'descripcion' => $descripcion,
            'nombre'=>$nombre,
            'fechaDeCreada' => $fechaDeCreada,
            'fechaDeCumplimiento'=> $fechaDeCumplimiento,
            'asignadaToTrabajador' => $asignadaA,
            'creadaPor' => $creadaPor,
            'cumplida' => $cumplida,
            'id'=>$id
        ));
        $consulta1->getResult();
        $oferta = $consulta->getResult();

        return $oferta;
       // UPDATE OfertaBundle:Oferta o SET o.precio = o.precio * 1.10
    }
	
	  public function findPorFecha($fechaInicial,$fechaFinal)
    {
        $em = $this->getEntityManager();

        $consulta = $em->createQuery('SELECT t FROM FrontedBundle:GastosVariados t WHERE
        t.fecha >= :fechaInicial AND
        t.fecha <= :fechaFinal ORDER BY t.fecha ASC');

        $consulta->setParameters(array(
            'fechaInicial' => $fechaInicial,
            'fechaFinal' => $fechaFinal
        ));

        $oferta = $consulta->getResult();

        return $oferta;


    }

} 