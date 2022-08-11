<?php
/**
 * Created by PhpStorm.
 * User: Fernando
 * Date: 2/27/15
 * Time: 11:55 PM
 */


namespace Gatorno\FrontedBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass = "Gatorno\FrontedBundle\Repository\appUserRepository")
 * @UniqueEntity("nombre", message = "Por favor, escoja otro nombre")
 */
class appUser implements UserInterface
 {
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
     private  $id;
    public function getId()
    {
        return $this->id;
    }

    /**
     * @ORM\Column(type="string", length=100)
     *@Assert\NotBlank(message = "Por favor, escribe tu nombre")
     */
    protected $nombre;

    public function __toString()
    {
        return $this->getnombre();
    }
  

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message = "El campo Contraseña no puede estar vacio")
     * @Assert\Length(min = 6)
     */
    protected $password;



    /**
     * @ORM\Column(type="string", length=255)
     *@Assert\NotBlank()
     */
    protected $cargo;

    /** @ORM\Column(type="string", length=255) */
    protected $salt;




 
    /**
     * Set nombre
     *
     * @param string $nombre
     * @return user
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
     * Set password
     *
     * @param string $password
     * @return user
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set cargo
     *
     * @param string $cargo
     * @return user
     */
    public function setCargo($cargo)
    {
        $this->cargo = $cargo;

        return $this;
    }

    /**
     * Get cargo
     *
     * @return string 
     */
    public function getCargo()
    {
        return $this->cargo;
    }

    function eraseCredentials()
    {
    }
    function getRoles()
    {
        return array($this->getCargo());
    }
    function getUsername()
    {
        return $this->getNombre();
    }

    /*
     * yo
     */
    function getSalt()
    {
        return $this->salt;
    }

    /*
     * yo
     */
    function setSalt($salt)
    {
        $this->salt = $salt;
    }
}
