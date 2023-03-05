<?php

namespace App\Entity;

use App\Repository\PreferenciasRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PreferenciasRepository::class)]
class Preferencias
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $types = null;

    #[ORM\OneToMany(mappedBy: 'preferencias', targetEntity: Actividades::class)]
    private Collection $preferencia;

    #[ORM\OneToMany(mappedBy: 'preferencia', targetEntity: Cliente::class)]
    private Collection $clientes;

    public function __construct()
    {
        $this->preferencia = new ArrayCollection();
        $this->clientes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypes(): ?string
    {
        return $this->types;
    }

    public function setTypes(string $types): self
    {
        $this->types = $types;

        return $this;
    }

    /**
     * @return Collection<int, Actividades>
     */
    public function getPreferencia(): Collection
    {
        return $this->preferencia;
    }

    public function addPreferencium(Actividades $preferencium): self
    {
        if (!$this->preferencia->contains($preferencium)) {
            $this->preferencia->add($preferencium);
            $preferencium->setPreferencias($this);
        }

        return $this;
    }

    public function removePreferencium(Actividades $preferencium): self
    {
        if ($this->preferencia->removeElement($preferencium)) {
            // set the owning side to null (unless already changed)
            if ($preferencium->getPreferencias() === $this) {
                $preferencium->setPreferencias(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Cliente>
     */
    public function getClientes(): Collection
    {
        return $this->clientes;
    }

    public function addCliente(Cliente $cliente): self
    {
        if (!$this->clientes->contains($cliente)) {
            $this->clientes->add($cliente);
            $cliente->setPreferencia($this);
        }

        return $this;
    }

    public function removeCliente(Cliente $cliente): self
    {
        if ($this->clientes->removeElement($cliente)) {
            // set the owning side to null (unless already changed)
            if ($cliente->getPreferencia() === $this) {
                $cliente->setPreferencia(null);
            }
        }

        return $this;
    }
}
