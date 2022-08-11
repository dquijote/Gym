<?php
/**
 * Created by PhpStorm.
 * User: Instructores
 * Date: 8/12/15
 * Time: 15:48
 */
/**
 * Created by PhpStorm.
 * User: MaiteFelipe
 * Date: 24/09/15
 * Time: 18:45
 */


namespace Gatorno\FrontedBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;



/**
 *
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass = "Gatorno\FrontedBundle\Repository\ClienteRepository")
 *
 *
 */
class Cliente {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    public function __toString()
    {
       return $this->nombre ;
    }

    /**
     * @Assert\Image(maxSize = "5000k")
     */
    protected $foto;

    /**
     *
     * @ORM\Column(type="integer")
     */
    private $clave;

    /**
     *
     *@ORM\Column(type="date")
     */
    private $fechaDeIngreso;

    /**
     *
     *@ORM\Column(type="date")
     */
    private $fechaDePago;

    /**
     *@ORM\Column( type="string")
     */
    private $nombre;
    /**
     *@ORM\Column( type="string")
     */
    private $apellidos;

    /**
     *
     *@ORM\Column(type="string")
     */
    private $tipo;

    /**
     *@ORM\Column(type="string")
     */
    private $sexo;

    /**
     *@ORM\Column(type="string")
     */
    private $servicio;

    /**
     *@ORM\Column(type="integer")
     */
    private $costoDeservicio;

    /**
     *@ORM\Column(type="string")
     */
    private $fotoRuta;

    public function subirFoto($directorioDestino)
    {
        if (null === $this->foto) {
            return;
        }

       // $directorioDestino = __DIR__.'/../../../../web/uploads/images';
        $nombreArchivoFoto = $this->foto->getClientOriginalName();
        $this->foto->move($directorioDestino, $nombreArchivoFoto);
        $this->setFotoRuta($nombreArchivoFoto);
    }



    /**
     * @param UploadedFile $foto
     */
    public function setFoto(UploadedFile $foto = null)
    {
        $this->foto = $foto;
    }
    /**
     * @return UploadedFile
     */
    public function getFoto()
    {
        return $this->foto;
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
     * Set clave
     *
     * @param integer $clave
     * @return Cliente
     */
    public function setClave($clave)
    {
        $this->clave = $clave;

        return $this;
    }

    /**
     * Get clave
     *
     * @return integer 
     */
    public function getClave()
    {
        return $this->clave;
    }

    /**
     * Set fechaDeIngreso
     *
     * @param \DateTime $fechaDeIngreso
     * @return Cliente
     */
    public function setFechaDeIngreso($fechaDeIngreso)
    {
        $this->fechaDeIngreso = $fechaDeIngreso;

        return $this;
    }

    /**
     * Get fechaDeIngreso
     *
     * @return \DateTime 
     */
    public function getFechaDeIngreso()
    {
        return $this->fechaDeIngreso;
    }

    /**
     * Set fechaDePago
     *
     * @param \DateTime $fechaDePago
     * @return Cliente
     */
    public function setFechaDePago($fechaDePago)
    {
        $this->fechaDePago = $fechaDePago;

        return $this;
    }

    /**
     * Get fechaDePago
     *
     * @return \DateTime 
     */
    public function getFechaDePago()
    {
        return $this->fechaDePago;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Cliente
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set apellidos
     *
     * @param string $apellidos
     * @return Cliente
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    /**
     * Get apellidos
     *
     * @return string 
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     * @return Cliente
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return string 
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set sexo
     *
     * @param string $sexo
     * @return Cliente
     */
    public function setSexo($sexo)
    {
        $this->sexo = $sexo;

        return $this;
    }

    /**
     * Get sexo
     *
     * @return string 
     */
    public function getSexo()
    {
        return $this->sexo;
    }

    /**
     * Set servicio
     *
     * @param string $servicio
     * @return Cliente
     */
    public function setServicio($servicio)
    {
        $this->servicio = $servicio;

        return $this;
    }

    /**
     * Get servicio
     *
     * @return string 
     */
    public function getServicio()
    {
        return $this->servicio;
    }

    /**
     * Set costoDeservicio
     *
     * @param integer $costoDeservicio
     * @return Cliente
     */
    public function setCostoDeservicio($costoDeservicio)
    {
        $this->costoDeservicio = $costoDeservicio;

        return $this;
    }

    /**
     * Get costoDeservicio
     *
     * @return integer 
     */
    public function getCostoDeservicio()
    {
        return $this->costoDeservicio;
    }

    /**
     * Set fotoRuta
     *
     * @param string $fotoRuta
     * @return Cliente
     */
    public function setFotoRuta($fotoRuta)
    {
        $this->fotoRuta = $fotoRuta;

        return $this;
    }

    /**
     * Get fotoRuta
     *
     * @return string 
     */
    public function getFotoRuta()
    {
        return $this->fotoRuta;
    }
}
