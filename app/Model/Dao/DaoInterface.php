<?php
namespace App\Model\Dao;

use App\Model\Entity\Entidade;

// Contrato do CRUD que todo DAO precisa cumprir
interface DaoInterface
{
    public function inserir(Entidade $entidade): int;

    public function buscarPorId(int $id): ?Entidade;

    public function listarTodos(): array;

    public function atualizar(Entidade $entidade): bool;

    public function excluir(int $id): bool;
}
