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


class ClienteRepository  extends EntityRepository{

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
        $cliente = $em->getRepository("FrontedBundle:Cliente")->find($id);
        $tipoCliente = $em->getRepository("FrontedBundle:TipoCliente")->findOneBy(array("tipo" => $cliente->getTipo()));
        $consulta1 = $em->createQuery('UPDATE FrontedBundle:cliente c
                                        SET c.fechaDePago = :fechaDePago,
                                        c.costoDeservicio = :costoDeServicio 
                                        WHERE c.id = :id');


        $consulta1->setParameters(array(
            'id' => $id,
            'fechaDePago' => $fechaDePago,
            "costoDeServicio" => $tipoCliente->getImporte()

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

//  Fecha de ingreso (Paginator)
    public function findFiltroFechaPaginator($fechaInicial,$fechaFinal)
    {
        $em = $this->getEntityManager();

        $consulta = $em->createQuery('SELECT c FROM FrontedBundle:Cliente c WHERE
        c.fechaDeIngreso >= :fechaInicial AND
        c.fechaDeIngreso <= :fechaFinal ORDER BY c.fechaDeIngreso ASC');

        $consulta->setParameters(array(
            'fechaInicial' => $fechaInicial,
            'fechaFinal' => $fechaFinal
        ));

//        $oferta = $consulta->getResult();

        return $consulta;


    }
//    Fecha de ingreso y tipo
    public function findFiltroFechaTipo($fechaInicial,$fechaFinal, $tipo)
    {
        $em = $this->getEntityManager();

        $consulta = $em->createQuery('SELECT c FROM FrontedBundle:Cliente c WHERE
        c.fechaDeIngreso >= :fechaInicial AND
        c.fechaDeIngreso <= :fechaFinal AND c.tipo = :tipo ORDER BY c.fechaDeIngreso ASC');

        $consulta->setParameters(array(
            'fechaInicial' => $fechaInicial,
            'fechaFinal' => $fechaFinal,
            'tipo' => $tipo
        ));

        $oferta = $consulta->getResult();

        return $oferta;


    }

    //    Fecha de ingreso y tipo (Paginator)
    public function findFiltroFechaTipoPaginator($fechaInicial,$fechaFinal, $tipo)
    {
        $em = $this->getEntityManager();

        $consulta = $em->createQuery('SELECT c FROM FrontedBundle:Cliente c WHERE
        c.fechaDeIngreso >= :fechaInicial AND
        c.fechaDeIngreso <= :fechaFinal AND c.tipo = :tipo ORDER BY c.fechaDeIngreso ASC');

        $consulta->setParameters(array(
            'fechaInicial' => $fechaInicial,
            'fechaFinal' => $fechaFinal,
            'tipo' => $tipo
        ));

//        $oferta = $consulta->getResult();

        return $consulta;


    }
//    Fecha de ingreso y sexo
    public function findFiltroFechaSexo($fechaInicial,$fechaFinal, $sexo)
    {
        $em = $this->getEntityManager();

        $consulta = $em->createQuery('SELECT c FROM FrontedBundle:Cliente c WHERE
        c.fechaDeIngreso >= :fechaInicial AND
        c.fechaDeIngreso <= :fechaFinal AND c.sexo = :sexo ORDER BY c.fechaDeIngreso ASC');

        $consulta->setParameters(array(
            'fechaInicial' => $fechaInicial,
            'fechaFinal' => $fechaFinal,
            'sexo' => $sexo
        ));

        $oferta = $consulta->getResult();

        return $oferta;
    }

    //    Fecha de ingreso y sexo (Paginator)
    public function findFiltroFechaSexoPaginator($fechaInicial,$fechaFinal, $sexo)
    {
        $em = $this->getEntityManager();

        $consulta = $em->createQuery('SELECT c FROM FrontedBundle:Cliente c WHERE
        c.fechaDeIngreso >= :fechaInicial AND
        c.fechaDeIngreso <= :fechaFinal AND c.sexo = :sexo ORDER BY c.fechaDeIngreso ASC');

        $consulta->setParameters(array(
            'fechaInicial' => $fechaInicial,
            'fechaFinal' => $fechaFinal,
            'sexo' => $sexo
        ));

//        $oferta = $consulta->getResult();

        return $consulta;
    }

//    Fecha de ingreso + sexo + tipo
    public function findFiltroFechaSexoTipo($fechaInicial,$fechaFinal, $sexo, $tipo)
    {
        $em = $this->getEntityManager();

        $consulta = $em->createQuery('SELECT c FROM FrontedBundle:Cliente c WHERE
        c.fechaDeIngreso >= :fechaInicial AND
        c.fechaDeIngreso <= :fechaFinal AND 
        c.sexo = :sexo AND 
        c.tipo = :tipo
        ORDER BY c.fechaDeIngreso ASC');

        $consulta->setParameters(array(
            'fechaInicial' => $fechaInicial,
            'fechaFinal' => $fechaFinal,
            'sexo' => $sexo,
            'tipo' => $tipo
        ));

        $oferta = $consulta->getResult();

        return $oferta;
    }

    //    Fecha de ingreso + sexo + tipo (Paginator)
    public function findFiltroFechaSexoTipoPaginator($fechaInicial,$fechaFinal, $sexo, $tipo)
    {
        $em = $this->getEntityManager();

        $consulta = $em->createQuery('SELECT c FROM FrontedBundle:Cliente c WHERE
        c.fechaDeIngreso >= :fechaInicial AND
        c.fechaDeIngreso <= :fechaFinal AND 
        c.sexo = :sexo AND 
        c.tipo = :tipo
        ORDER BY c.fechaDeIngreso ASC');

        $consulta->setParameters(array(
            'fechaInicial' => $fechaInicial,
            'fechaFinal' => $fechaFinal,
            'sexo' => $sexo,
            'tipo' => $tipo
        ));

//        $oferta = $consulta->getResult();

        return $consulta;
    }

//    Fecha de pago y sexo
    public function findRangeFechaDePagoSexo($fechaInicial,$fechaFinal, $sexo)
    {
        $em = $this->getEntityManager();

        $consulta = $em->createQuery('SELECT c FROM FrontedBundle:Cliente c WHERE
        c.fechaDePago >= :fechaInicial AND
        c.fechaDePago <= :fechaFinal AND c.sexo = :sexo ORDER BY c.fechaDeIngreso ASC');

        $consulta->setParameters(array(
            'fechaInicial' => $fechaInicial,
            'fechaFinal' => $fechaFinal,
            'sexo' => $sexo
        ));

        $oferta = $consulta->getResult();

        return $oferta;
    }
//    Fecha de pago y sexo (Paginator)
    public function findRangeFechaDePagoSexoPaginator($fechaInicial,$fechaFinal, $sexo)
    {
        $em = $this->getEntityManager();

        $consulta = $em->createQuery('SELECT c FROM FrontedBundle:Cliente c WHERE
        c.fechaDePago >= :fechaInicial AND
        c.fechaDePago <= :fechaFinal AND c.sexo = :sexo ORDER BY c.fechaDeIngreso ASC');

        $consulta->setParameters(array(
            'fechaInicial' => $fechaInicial,
            'fechaFinal' => $fechaFinal,
            'sexo' => $sexo
        ));

//        $oferta = $consulta->getResult();

        return $consulta;
    }

//    Fecha de pago y tipo
    public function findRangeFechaDePagoTipo($fechaInicial,$fechaFinal, $tipo)
    {
        $em = $this->getEntityManager();

        $consulta = $em->createQuery('SELECT c FROM FrontedBundle:Cliente c WHERE
        c.fechaDePago >= :fechaInicial AND
        c.fechaDePago <= :fechaFinal AND c.tipo = :tipo ORDER BY c.fechaDeIngreso ASC');

        $consulta->setParameters(array(
            'fechaInicial' => $fechaInicial,
            'fechaFinal' => $fechaFinal,
            'tipo' => $tipo
        ));

        $oferta = $consulta->getResult();

        return $oferta;
    }

    //    Fecha de pago y tipo (Paginator)
    public function findRangeFechaDePagoTipoPaginator($fechaInicial,$fechaFinal, $tipo)
    {
        $em = $this->getEntityManager();

        $consulta = $em->createQuery('SELECT c FROM FrontedBundle:Cliente c WHERE
        c.fechaDePago >= :fechaInicial AND
        c.fechaDePago <= :fechaFinal AND c.tipo = :tipo ORDER BY c.fechaDeIngreso ASC');

        $consulta->setParameters(array(
            'fechaInicial' => $fechaInicial,
            'fechaFinal' => $fechaFinal,
            'tipo' => $tipo
        ));

//        $oferta = $consulta->getResult();

        return $consulta;
    }

//    Fecha de pago + tipo + sexo
    public function findRangeFechaDePagoTipoSexo($fechaInicial, $fechaFinal, $tipo, $sexo)
    {
        $em = $this->getEntityManager();

        $consulta = $em->createQuery('SELECT c FROM FrontedBundle:Cliente c WHERE
        c.fechaDePago >= :fechaInicial AND
        c.fechaDePago <= :fechaFinal AND 
        c.tipo = :tipo AND 
        c.sexo = :sexo
        ORDER BY c.fechaDeIngreso ASC');

        $consulta->setParameters(array(
            'fechaInicial' => $fechaInicial,
            'fechaFinal' => $fechaFinal,
            'tipo' => $tipo,
            'sexo' => $sexo
        ));

        $oferta = $consulta->getResult();

        return $oferta;
    }

    //    Fecha de pago + tipo + sexo (Paginator)
    public function findRangeFechaDePagoTipoSexoPaginator($fechaInicial, $fechaFinal, $tipo, $sexo)
    {
        $em = $this->getEntityManager();

        $consulta = $em->createQuery('SELECT c FROM FrontedBundle:Cliente c WHERE
        c.fechaDePago >= :fechaInicial AND
        c.fechaDePago <= :fechaFinal AND 
        c.tipo = :tipo AND 
        c.sexo = :sexo
        ORDER BY c.fechaDeIngreso ASC');

        $consulta->setParameters(array(
            'fechaInicial' => $fechaInicial,
            'fechaFinal' => $fechaFinal,
            'tipo' => $tipo,
            'sexo' => $sexo
        ));

//        $oferta = $consulta->getResult();

        return $consulta;
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

    public function findFechaDePagoPaginator($fechaInicial,$fechaFinal)
    {
        $em = $this->getEntityManager();

        $consulta = $em->createQuery('SELECT c FROM FrontedBundle:Cliente c WHERE
        c.fechaDePago >= :fechaInicial AND
        c.fechaDePago <= :fechaFinal ORDER BY c.fechaDePago ASC');

        $consulta->setParameters(array(
            'fechaInicial' => $fechaInicial,
            'fechaFinal' => $fechaFinal
        ));

//        $oferta = $consulta->getResult();

        return $consulta;


    }

    public function findByTipo($tipo){
        $em = $this->getEntityManager();

        $consulta = $em->createQuery('SELECT c FROM FrontedBundle:Cliente c WHERE
        c.tipo >= :tipo  ORDER BY c.fechaDePago ASC');

        $consulta->setParameters(array(
            'tipo' => $tipo,
        ));

        $oferta = $consulta->getResult();

        return $oferta;
    }

    public function findClaveCliente()
    {
        $em = $this->getEntityManager();

        $consulta = $em->createQuery('SELECT c.clave FROM FrontedBundle:Cliente c ');

        $oferta = $consulta->getResult();

        return $oferta;


    }

    /*
     * Buscar en la tabla cliente por los criterios Nombre y Apellidos
     *
     * */
    public function findClienteNombreApellido($nombre, $apellido)
    {
        $em = $this->getEntityManager();

        $consulta = $em->createQuery('SELECT c FROM FrontedBundle:Cliente c WHERE
        c.nombre LIKE :nombre AND
        c.apellidos LIKE :apellidos  ORDER BY c.fechaDePago DESC ');

        $consulta->setParameters(array(
            'nombre' => '%'.$nombre.'%',
            'apellidos' => '%'.$apellido.'%',
        ));

        $oferta = $consulta->getResult();

        return $oferta;
    }

} 