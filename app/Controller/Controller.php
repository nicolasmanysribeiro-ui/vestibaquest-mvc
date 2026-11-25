<?php
namespace App\Controller;

// Base dos controllers: desenhar telas, redirecionar e mensagens rápidas
abstract class Controller
{
    protected function render(string $view, array $dados = []): void
    {
        extract($dados);
        $flash = $_SESSION['flash'] ?? null;
        unset($_SESSION['flash']);
        $arquivoView = __DIR__ . '/../View/' . $view . '.php';
        require __DIR__ . '/../View/layout.php';
    }

    protected function redirecionar(string $rota, string $mensagem = '', string $tipo = 'ok'): void
    {
        if ($mensagem !== '') {
            $_SESSION['flash'] = ['mensagem' => $mensagem, 'tipo' => $tipo];
        }
        header('Location: index.php?' . $rota);
        exit;
    }

    protected function idDaUrl(): int
    {
        return (int) ($_GET['id'] ?? $_POST['id'] ?? 0);
    }

    protected function exigirPost(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirecionar('c=painel');
        }
    }
}
