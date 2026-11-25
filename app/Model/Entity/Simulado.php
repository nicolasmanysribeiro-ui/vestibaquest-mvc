<?php
namespace App\Model\Entity;

use App\Exception\ValidacaoException;

class Simulado extends Entidade
{
    public const AREAS = ['Conhecimentos Gerais', 'Linguagens', 'Matemática', 'Ciências da Natureza', 'Ciências Humanas', 'Redação'];
    public const DIFICULDADES = ['Fácil', 'Média', 'Difícil'];

    private int $universidadeId = 0;
    private string $titulo = '';
    private int $ano = 0;
    private string $area = 'Conhecimentos Gerais';
    private int $qtdQuestoes = 0;
    private string $dificuldade = 'Média';
    private ?Universidade $universidade = null;

    public function getUniversidadeId(): int { return $this->universidadeId; }
    public function setUniversidadeId(int $id): void { $this->universidadeId = $id; }

    public function getTitulo(): string { return $this->titulo; }
    public function setTitulo(string $titulo): void { $this->titulo = trim($titulo); }

    public function getAno(): int { return $this->ano; }
    public function setAno(int $ano): void { $this->ano = $ano; }

    public function getArea(): string { return $this->area; }
    public function setArea(string $area): void { $this->area = $area; }

    public function getQtdQuestoes(): int { return $this->qtdQuestoes; }
    public function setQtdQuestoes(int $qtd): void { $this->qtdQuestoes = $qtd; }

    public function getDificuldade(): string { return $this->dificuldade; }
    public function setDificuldade(string $dificuldade): void { $this->dificuldade = $dificuldade; }

    // Objeto da universidade dona do simulado, preenchido pelo DAO com JOIN
    public function getUniversidade(): ?Universidade { return $this->universidade; }
    public function setUniversidade(?Universidade $universidade): void { $this->universidade = $universidade; }

    public function validar(): void
    {
        $erros = [];
        $anoAtual = (int) date('Y');
        if ($this->universidadeId <= 0) {
            $erros[] = 'Escolha a universidade do simulado.';
        }
        if (mb_strlen($this->titulo) < 3) {
            $erros[] = 'O título precisa ter pelo menos 3 letras.';
        }
        if ($this->ano < 1990 || $this->ano > $anoAtual) {
            $erros[] = "O ano deve estar entre 1990 e {$anoAtual}.";
        }
        if (!in_array($this->area, self::AREAS, true)) {
            $erros[] = 'Área inválida.';
        }
        if ($this->qtdQuestoes < 1 || $this->qtdQuestoes > 200) {
            $erros[] = 'A quantidade de questões deve ficar entre 1 e 200.';
        }
        if (!in_array($this->dificuldade, self::DIFICULDADES, true)) {
            $erros[] = 'Dificuldade inválida.';
        }
        if ($erros) {
            throw new ValidacaoException($erros);
        }
    }
}
