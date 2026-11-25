<?php
namespace App\Model\Dao;

use App\Model\Entity\Entidade;
use App\Model\Entity\Simulado;
use App\Model\Entity\Universidade;

class SimuladoDao extends BaseDao
{
    protected string $tabela = 'simulado';

    private const SELECT_COM_UNIVERSIDADE =
        'SELECT s.*, u.nome AS u_nome, u.sigla AS u_sigla, u.cidade AS u_cidade, u.tipo AS u_tipo
         FROM simulado s
         INNER JOIN universidade u ON u.id = s.universidade_id';

    protected function mapear(array $linha): Simulado
    {
        $s = new Simulado();
        $s->setId((int) $linha['id']);
        $s->setUniversidadeId((int) $linha['universidade_id']);
        $s->setTitulo($linha['titulo']);
        $s->setAno((int) $linha['ano']);
        $s->setArea($linha['area']);
        $s->setQtdQuestoes((int) $linha['qtd_questoes']);
        $s->setDificuldade($linha['dificuldade']);

        // Se veio do JOIN, já monta o objeto Universidade junto
        if (isset($linha['u_sigla'])) {
            $u = new Universidade($linha['u_nome'], $linha['u_sigla'], $linha['u_cidade'], $linha['u_tipo']);
            $u->setId((int) $linha['universidade_id']);
            $s->setUniversidade($u);
        }
        return $s;
    }

    public function inserir(Entidade $s): int
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO simulado (universidade_id, titulo, ano, area, qtd_questoes, dificuldade)
             VALUES (:universidade_id, :titulo, :ano, :area, :qtd_questoes, :dificuldade)'
        );
        $stmt->execute($this->parametros($s));
        $id = (int) $this->pdo->lastInsertId();
        $s->setId($id);
        return $id;
    }

    public function atualizar(Entidade $s): bool
    {
        $stmt = $this->pdo->prepare(
            'UPDATE simulado SET universidade_id = :universidade_id, titulo = :titulo, ano = :ano,
             area = :area, qtd_questoes = :qtd_questoes, dificuldade = :dificuldade WHERE id = :id'
        );
        $stmt->execute($this->parametros($s) + ['id' => $s->getId()]);
        return true;
    }

    public function buscarPorId(int $id): ?Simulado
    {
        $stmt = $this->pdo->prepare(self::SELECT_COM_UNIVERSIDADE . ' WHERE s.id = :id');
        $stmt->execute(['id' => $id]);
        $linha = $stmt->fetch();
        return $linha ? $this->mapear($linha) : null;
    }

    public function listarTodos(): array
    {
        $sql = self::SELECT_COM_UNIVERSIDADE . ' ORDER BY u.sigla, s.ano DESC, s.titulo';
        return array_map([$this, 'mapear'], $this->pdo->query($sql)->fetchAll());
    }

    public function listarPorUniversidade(int $universidadeId): array
    {
        $stmt = $this->pdo->prepare(self::SELECT_COM_UNIVERSIDADE . ' WHERE s.universidade_id = :id ORDER BY s.ano DESC, s.titulo');
        $stmt->execute(['id' => $universidadeId]);
        return array_map([$this, 'mapear'], $stmt->fetchAll());
    }

    public function contarPorUniversidade(int $universidadeId): int
    {
        $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM simulado WHERE universidade_id = :id');
        $stmt->execute(['id' => $universidadeId]);
        return (int) $stmt->fetchColumn();
    }

    public function totalQuestoes(): int
    {
        return (int) $this->pdo->query('SELECT COALESCE(SUM(qtd_questoes), 0) FROM simulado')->fetchColumn();
    }

    private function parametros(Simulado $s): array
    {
        return [
            'universidade_id' => $s->getUniversidadeId(),
            'titulo' => $s->getTitulo(),
            'ano' => $s->getAno(),
            'area' => $s->getArea(),
            'qtd_questoes' => $s->getQtdQuestoes(),
            'dificuldade' => $s->getDificuldade(),
        ];
    }
}
