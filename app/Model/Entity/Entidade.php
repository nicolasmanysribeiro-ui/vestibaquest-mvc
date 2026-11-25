<?php
namespace App\Model\Entity;

// Classe base de todas as entidades: id comum e validação obrigatória
abstract class Entidade
{
    protected ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function isNova(): bool
    {
        return $this->id === null;
    }

    // Cada entidade define suas próprias regras de validação
    abstract public function validar(): void;
}
