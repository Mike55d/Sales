<?php

namespace App\Entity;

use App\Repository\UnidadRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UnidadRepository::class)
 */
class Unidad
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
	private $nombre;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $encargado;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $emailEncargado;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $endereso;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $ciudad;

	/**
	 * @ORM\Column(type="boolean", length=255)
	 */
	private $emailDetallado;

	/**
	 * @ORM\ManyToOne(targetEntity=Asociacion::class)
	 * @ORM\JoinColumn(nullable=true )
	 */
	private $asociacion;

	/**
	 * @ORM\Column(type="boolean")
	 */
	private $activa;

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getNombre(): ?string
	{
		return $this->nombre;
	}

	public function setNombre(string $nombre): self
	{
		$this->nombre = $nombre;

		return $this;
	}

	public function getActiva(): ?bool
	{
		return $this->activa;
	}

	public function setActiva(bool $activa): self
	{
		$this->activa = $activa;

		return $this;
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

	public function getEncargado(): ?string
	{
		return $this->encargado;
	}

	public function setEncargado(string $encargado): self
	{
		$this->encargado = $encargado;

		return $this;
	}

	public function getEmailEncargado(): ?string
	{
		return $this->emailEncargado;
	}

	public function setEmailEncargado(string $emailEncargado): self
	{
		$this->emailEncargado = $emailEncargado;

		return $this;
	}

	public function getEndereso(): ?string
	{
		return $this->endereso;
	}

	public function setEndereso(string $endereso): self
	{
		$this->endereso = $endereso;

		return $this;
	}

	public function getCiudad(): ?string
	{
		return $this->ciudad;
	}

	public function setCiudad(string $ciudad): self
	{
		$this->ciudad = $ciudad;

		return $this;
	}

	public function getEmailDetallado(): ?bool
	{
		return $this->emailDetallado;
	}

	public function setEmailDetallado(bool $emailDetallado): self
	{
		$this->emailDetallado = $emailDetallado;

		return $this;
	}

	public function getAsociacion(): ?Asociacion
	{
		return $this->asociacion;
	}

	public function setAsociacion(?Asociacion $asociacion): self
	{
		$this->asociacion = $asociacion;

		return $this;
	}
}
