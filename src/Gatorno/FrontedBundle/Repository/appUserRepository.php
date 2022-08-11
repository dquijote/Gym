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


class appUserRepository  extends EntityRepository{

    public function Update($entity,$id)
    {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('
                        UPDATE FrontedBundle:appUser c SET c.nombre = :nombre,
                        c.password = :pass,
                        c.cargo = :cargo
                        where c.id = :id');
        $consulta->setParameters(array(
            'nombre' => $entity->getNombre(),
            'pass' => $entity->getPassword(),
            'cargo' => $entity->getCargo(),
            'id'=> $id,
        ));

        return $consulta->getResult();
    }
} 