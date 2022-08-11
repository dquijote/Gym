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


/**
 *
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass = "Gatorno\FrontedBundle\Repository\TrabajadorRepository")
 */
class Trabajador {

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
       return $this->getNombre() ;
    }


    /**
     *@ORM\ManyToOne(targetEntity="Gatorno\FrontedBundle\Entity\Cargo")
     *
     */
    private $cargo;

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
     *@ORM\Column(type="string")
     */
    private $sexo;


    /**
     *@ORM\Column(type="string")
     */
    private $fotoRuta;

    /**
     * @Assert\Image(maxSize = "5000k")
     */
    protected $foto;


    
   
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
     * Set fechaDeIngreso
     *
     * @param \DateTime $fechaDeIngreso
     * @return Trabajador
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
     * @return Trabajador
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
     * @return Trabajador
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
     * @return Trabajador
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
     * Set sexo
     *
     * @param string $sexo
     * @return Trabajador
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
     * Set fotoRuta
     *
     * @param string $fotoRuta
     * @return Trabajador
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
     * Set cargo
     *
     * @param \Gatorno\FrontedBundle\Entity\Cargo $cargo
     * @return Trabajador
     */
    public function setCargo(\Gatorno\FrontedBundle\Entity\Cargo $cargo = null)
    {
        $this->cargo = $cargo;

        return $this;
    }

    /**
     * Get cargo
     *
     * @return \Gatorno\FrontedBundle\Entity\Cargo 
     */
    public function getCargo()
    {
        return $this->cargo;
    }
}
