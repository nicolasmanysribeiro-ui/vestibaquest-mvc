<?php
namespace App\Model\Entity;

use App\Exception\ValidacaoException;

class Universidade extends Entidade
{
    public const TIPOS = ['Estadual', 'Federal', 'Privada'];

    private string $nome = '';
    private string $sigla = '';
    private string $cidade = '';
    private string $tipo = 'Estadual';
    private int $totalSimulados = 0;

    public function __construct(string $nome = '', string $sigla = '', string $cidade = '', string $tipo = 'Estadual')
    {
        $this->setNome($nome);
        $this->setSigla($sigla);
        $this->setCidade($cidade);
        $this->setTipo($tipo);
    }

    public function getNome(): string { return $this->nome; }
    public function setNome(string $nome): void { $this->nome = trim($nome); }

    public function getSigla(): string { return $this->sigla; }
    public function setSigla(string $sigla): void { $this->sigla = strtoupper(trim($sigla)); }

    public function getCidade(): string { return $this->cidade; }
    public function setCidade(string $cidade): void { $this->cidade = trim($cidade); }

    public function getTipo(): string { return $this->tipo; }
    public function setTipo(string $tipo): void { $this->tipo = $tipo; }

    public function getTotalSimulados(): int { return $this->totalSimulados; }
    public function setTotalSimulados(int $total): void { $this->totalSimulados = $total; }

    public function validar(): void
    {
        $erros = [];
        if (mb_strlen($this->nome) < 3) {
            $erros[] = 'O nome precisa ter pelo menos 3 letras.';
        }
        if ($this->sigla === '' || mb_strlen($this->sigla) > 15) {
            $erros[] = 'Informe uma sigla de até 15 caracteres.';
        }
        if ($this->cidade === '') {
            $erros[] = 'Informe a cidade.';
        }
        if (!in_array($this->tipo, self::TIPOS, true)) {
            $erros[] = 'Tipo de universidade inválido.';
        }
        if ($erros) {
            throw new ValidacaoException($erros);
        }
    }
}
