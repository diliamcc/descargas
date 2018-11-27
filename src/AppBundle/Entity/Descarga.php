<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo; // gedmo annotations

/**
 * Descarga
 *
 * @ORM\Table(name="descarga")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DescargaRepository")
 */
class Descarga
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, unique=true)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="usuario", type="string", length=55)
     */
    private $usuario;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=155)
     */
    private $nombre;


    /**
     * @var string
     *
     * @ORM\Column(name="correo", type="string", length=155)
     */
    private $correo;


    /**
     * @Gedmo\Slug(fields={"nombre"})
     * @ORM\Column(length=198, unique=true)
     */
    private $slug;


    /**
     * @var string
     *
     * @ORM\Column(name="ruta", type="string", length=155, nullable=true)
     */
    private $ruta;

    /**
     * @var boolean
     *
     * @ORM\Column(name="completada", type="boolean")
     */
    private $completada;

    /**
     * @var boolean
     *
     * @ORM\Column(name="privada", type="boolean", options={"default":0})
     */
    private $privada;

    /**
     * @var boolean
     *
     * @ORM\Column(name="directa", type="boolean", options={"default":0})
     */
    private $directa;


    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created", type="datetime")
     */
    private $creada;

    /**
     * @var \DateTime $completada_en
     *
     * @ORM\Column(name="completada_en", type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="change", field={"completada"})
     */
    private $completada_en;

    /**
     * @var string
     *
     * @ORM\Column(name="pc", type="string", length=55, nullable=true)
     */
    private $pc;



    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Descarga
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

 
    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Descarga
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
     * Set slug
     *
     * @param string $slug
     *
     * @return Descarga
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set ruta
     *
     * @param string $ruta
     *
     * @return Descarga
     */
    public function setRuta($ruta)
    {
        $this->ruta = $ruta;

        return $this;
    }

    /**
     * Get ruta
     *
     * @return string
     */
    public function getRuta()
    {
        return $this->ruta;
    }

    /**
     * Set completada
     *
     * @param boolean $completada
     *
     * @return Descarga
     */
    public function setCompletada($completada)
    {
        $this->completada = $completada;

        return $this;
    }

    /**
     * Get completada
     *
     * @return boolean
     */
    public function getCompletada()
    {
        return $this->completada;
    }

    /**
     * Set creada
     *
     * @param \DateTime $creada
     *
     * @return Descarga
     */
    public function setCreada($creada)
    {
        $this->creada = $creada;

        return $this;
    }

    /**
     * Get creada
     *
     * @return \DateTime
     */
    public function getCreada()
    {
        return $this->creada;
    }

    /**
     * Set completadaEn
     *
     * @param \DateTime $completadaEn
     *
     * @return Descarga
     */
    public function setCompletadaEn($completadaEn)
    {
        $this->completada_en = $completadaEn;

        return $this;
    }

    /**
     * Get completadaEn
     *
     * @return \DateTime
     */
    public function getCompletadaEn()
    {
        return $this->completada_en;
    }



    /**
     * Set pc
     *
     * @param string $pc
     *
     * @return Descarga
     */
    public function setPc($pc)
    {
        $this->pc = $pc;

        return $this;
    }

    /**
     * Get pc
     *
     * @return string
     */
    public function getPc()
    {
        return $this->pc;
    }

    /**
     * Set privada
     *
     * @param boolean $privada
     *
     * @return Descarga
     */
    public function setPrivada($privada)
    {
        $this->privada = $privada;

        return $this;
    }

    /**
     * Get privada
     *
     * @return boolean
     */
    public function getPrivada()
    {
        return $this->privada;
    }

    /**
     * Set directa
     *
     * @param boolean $directa
     *
     * @return Descarga
     */
    public function setDirecta($directa)
    {
        $this->directa = $directa;

        return $this;
    }

    /**
     * Get directa
     *
     * @return boolean
     */
    public function getDirecta()
    {
        return $this->directa;
    }

    /**
     * Set correo
     *
     * @param string $correo
     *
     * @return Descarga
     */
    public function setCorreo($correo)
    {
        $this->correo = $correo;

        return $this;
    }

    /**
     * Get correo
     *
     * @return string
     */
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * Set usuario
     *
     * @param string $usuario
     *
     * @return Descarga
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return string
     */
    public function getUsuario()
    {
        return $this->usuario;
    }
}
