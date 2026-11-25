<?php
// Front controller: toda requisição passa aqui e é enviada ao controller certo
session_start();
require __DIR__ . '/config/autoload.php';
require __DIR__ . '/config/helpers.php';

use App\Controller\PainelController;
use App\Controller\SimuladoController;
use App\Controller\UniversidadeController;

$rotas = [
    'painel' => PainelController::class,
    'universidade' => UniversidadeController::class,
    'simulado' => SimuladoController::class,
];

$c = $_GET['c'] ?? 'painel';
$a = $_GET['a'] ?? 'index';

try {
    if (!isset($rotas[$c])) {
        throw new RuntimeException('Página não encontrada.');
    }
    $controller = new $rotas[$c]();
    if (!method_exists($controller, $a)) {
        throw new RuntimeException('Ação não encontrada.');
    }
    $controller->$a();
} catch (PDOException $e) {
    http_response_code(500);
    echo '<h2>Erro de banco de dados</h2><p>Confira se o MySQL do XAMPP está ligado e se o script database/vestibaquest_mvc.sql foi importado.</p>';
    echo '<pre>' . htmlspecialchars($e->getMessage()) . '</pre>';
} catch (Throwable $e) {
    http_response_code(404);
    echo '<h2>Ops</h2><p>' . htmlspecialchars($e->getMessage()) . '</p><a href="index.php">Voltar</a>';
}
