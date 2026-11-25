<?php
namespace App\Model\Dao;

use App\Model\Entity\Entidade;
use App\Model\Entity\Universidade;

class UniversidadeDao extends BaseDao
{
    protected string $tabela = 'universidade';

    protected function mapear(array $linha): Universidade
    {
        $u = new Universidade($linha['nome'], $linha['sigla'], $linha['cidade'], $linha['tipo']);
        $u->setId((int) $linha['id']);
        if (isset($linha['total_simulados'])) {
            $u->setTotalSimulados((int) $linha['total_simulados']);
        }
        return $u;
    }

    public function inserir(Entidade $u): int
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO universidade (nome, sigla, cidade, tipo) VALUES (:nome, :sigla, :cidade, :tipo)'
        );
        $stmt->execute($this->parametros($u));
        $id = (int) $this->pdo->lastInsertId();
        $u->setId($id);
        return $id;
    }

    public function atualizar(Entidade $u): bool
    {
        $stmt = $this->pdo->prepare(
            'UPDATE universidade SET nome = :nome, sigla = :sigla, cidade = :cidade, tipo = :tipo WHERE id = :id'
        );
        $stmt->execute($this->parametros($u) + ['id' => $u->getId()]);
        return true;
    }

    // Lista com a contagem de simulados de cada universidade, mostrando o relacionamento
    public function listarTodos(): array
    {
        $sql = 'SELECT u.*, COUNT(s.id) AS total_simulados
                FROM universidade u
                LEFT JOIN simulado s ON s.universidade_id = u.id
                GROUP BY u.id
                ORDER BY u.sigla';
        return array_map([$this, 'mapear'], $this->pdo->query($sql)->fetchAll());
    }

    public function siglaEmUso(string $sigla, ?int $ignorarId = null): bool
    {
        $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM universidade WHERE sigla = :sigla AND id <> :id');
        $stmt->execute(['sigla' => $sigla, 'id' => $ignorarId ?? 0]);
        return (int) $stmt->fetchColumn() > 0;
    }

    private function parametros(Universidade $u): array
    {
        return [
            'nome' => $u->getNome(),
            'sigla' => $u->getSigla(),
            'cidade' => $u->getCidade(),
            'tipo' => $u->getTipo(),
        ];
    }
}
