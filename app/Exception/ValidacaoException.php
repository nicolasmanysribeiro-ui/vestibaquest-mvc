<?php
namespace App\Exception;

use Exception;

// Erro de dado inválido digitado pelo usuário
class ValidacaoException extends Exception
{
    private array $erros;

    public function __construct(array $erros)
    {
        parent::__construct(implode(' ', $erros));
        $this->erros = $erros;
    }

    public function getErros(): array
    {
        return $this->erros;
    }
}
