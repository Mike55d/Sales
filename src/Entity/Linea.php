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
    private $numero;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $operadora;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $chip;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tipo;

    /**
    * @ORM\ManyToOne(targetEntity=Unidad::class)
    * @ORM\JoinColumn(nullable=true , onDelete="SET NULL")
    */
    private $unidad;

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

    public function getOperadora(): ?string
    {
        return $this->operadora;
    }

    public function setOperadora(string $operadora): self
    {
        $this->operadora = $operadora;

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

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo): self
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
}
