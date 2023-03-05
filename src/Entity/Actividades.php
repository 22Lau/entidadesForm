<?php

namespace App\Entity;

use App\Repository\ActividadesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActividadesRepository::class)]
class Actividades
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nombre = null;

    #[ORM\Column(length: 255)]
    private ?string $descripcion = null;

    #[ORM\ManyToOne(inversedBy: 'preferencia')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Preferencias $preferencias = null;

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

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getPreferencias(): ?Preferencias
    {
        return $this->preferencias;
    }

    public function setPreferencias(?Preferencias $preferencias): self
    {
        $this->preferencias = $preferencias;

        return $this;
    }
}
