<?php
/**
 * Created by PhpStorm.
 * User: MaiteFelipe
 * Date: 20/09/15
 * Time: 1:35
 */

namespace Gatorno\FrontedBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Validator\Constraints\DateTime;

//use atis\userBundle\Entity;


class TrabajadorRepository  extends EntityRepository{



    public function updateFechaPago(\DateTime $fecha, $id)
    {
        //Actualizar la fecha de pago del trabajador
        $em = $this->getEntityManager();
        $consulta1 = $em->createQuery('UPDATE FrontedBundle:Trabajador g
                                        SET g.fechaDePago = :fecha
                                        where g.id = :id');

        $consulta1->setParameters(array(
            'id'=> $id,
            'fecha' => $fecha,

        ));

        $oferta = $consulta1->getResult();

        return $oferta;

    }

    public function findPropietario()
    {
        $em = $this->getEntityManager();

        $consulta = $em->createQueryBuilder('SELECT t FROM FrontedBundle:Trabajador t
        JOIN t.cargo c
         WHERE
          c.cargo =:Propietario
         ');

        $Propietario = 'Propietario';
        $qb = $em->createQueryBuilder()
                     ->select('u')
             ->from('FrontedBundle:Trabajador', 'u')
             ->join('u.cargo', 'p')
             ->where('p.cargo =:Propietario')
        ->setParameters(array('Propietario'=>$Propietario))
        ;

        $consulta->setParameters(array(
            'Propietario'=> 'Propietario',

        ));

        return $qb;



    }
	


} 