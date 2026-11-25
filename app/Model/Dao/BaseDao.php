<?php
namespace App\Model\Dao;

use App\Model\Entity\Entidade;
use PDO;

// Código repetido de todos os DAOs fica aqui, cada filho só diz a tabela e como montar o objeto
abstract class BaseDao implements DaoInterface
{
    protected PDO $pdo;
    protected string $tabela;

    public function __construct()
    {
        $this->pdo = Conexao::getInstancia();
    }

    abstract protected function mapear(array $linha): Entidade;

    public function buscarPorId(int $id): ?Entidade
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->tabela} WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $linha = $stmt->fetch();
        return $linha ? $this->mapear($linha) : null;
    }

    public function excluir(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->tabela} WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->rowCount() > 0;
    }

    public function contar(): int
    {
        return (int) $this->pdo->query("SELECT COUNT(*) FROM {$this->tabela}")->fetchColumn();
    }
}
