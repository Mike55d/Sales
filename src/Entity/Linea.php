<?php

namespace App\Entity;

use App\Repository\LineaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LineaRepository::class)
 */
class Linea
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ddd;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $numero;


    /**
     * @ORM\ManyToOne(targetEntity=Operadora::class)
     * @ORM\JoinColumn(nullable=true , onDelete="SET NULL")
     */
    private $operadora;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $chip;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $serie;

    /**
     * @ORM\Column(type="text", length=555 , nullable=true)
     */
    private $observaciones;

    /**
     * @ORM\ManyToOne(targetEntity=TipoDispositivo::class)
     * @ORM\JoinColumn(nullable=true )
     */
    private $tipo;

    /**
     * @ORM\ManyToOne(targetEntity=Unidad::class)
     * @ORM\JoinColumn(nullable=true )
     */
    private $unidad;

    /**
     * @ORM\Column(type="boolean", length=555)
     */
    private $active;

    /**
     * @ORM\Column(type="boolean", length=555)
     */
    private $internet;

    
    /**
     * @ORM\ManyToOne(targetEntity=UserLinea::class)
     * @ORM\JoinColumn(nullable=true )
     */
    private $userLinea;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getChip(): ?string
    {
        return $this->chip;
    }

    public function setChip(string $chip): self
    {
        $this->chip = $chip;

        return $this;
    }

    public function getOperadora(): ?Operadora
    {
        return $this->operadora;
    }

    public function setOperadora(?Operadora $operadora): self
    {
        $this->operadora = $operadora;

        return $this;
    }

    public function getTipo(): ?TipoDispositivo
    {
        return $this->tipo;
    }

    public function setTipo(?TipoDispositivo $tipo): self
    {
        $this->tipo = $tipo;

        return $this;
    }

    public function getUnidad(): ?Unidad
    {
        return $this->unidad;
    }

    public function setUnidad(?Unidad $unidad): self
    {
        $this->unidad = $unidad;

        return $this;
    }

    public function getDdd(): ?string
    {
        return $this->ddd;
    }

    public function setDdd(string $ddd): self
    {
        $this->ddd = $ddd;

        return $this;
    }

    public function getSerie(): ?string
    {
        return $this->serie;
    }

    public function setSerie(string $serie): self
    {
        $this->serie = $serie;

        return $this;
    }

    public function getObservaciones(): ?string
    {
        return $this->observaciones;
    }

    public function setObservaciones(string $observaciones): self
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getInternet(): ?bool
    {
        return $this->internet;
    }

    public function setInternet(bool $internet): self
    {
        $this->internet = $internet;

        return $this;
    }

    public function getUserLinea(): ?UserLinea
    {
        return $this->userLinea;
    }

    public function setUserLinea(?UserLinea $userLinea): self
    {
        $this->userLinea = $userLinea;

        return $this;
    }
}
