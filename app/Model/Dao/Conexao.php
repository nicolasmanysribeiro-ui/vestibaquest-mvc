<?php
namespace App\Model\Dao;

use PDO;

// Singleton: uma única conexão PDO compartilhada por todos os DAOs
final class Conexao
{
    private static ?PDO $instancia = null;

    private function __construct()
    {
    }

    public static function getInstancia(): PDO
    {
        if (self::$instancia === null) {
            $config = require __DIR__ . '/../../../config/config.php';
            $db = $config['db'];
            $dsn = "mysql:host={$db['host']};port={$db['porta']};dbname={$db['banco']};charset=utf8mb4";
            self::$instancia = new PDO($dsn, $db['usuario'], $db['senha'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        }
        return self::$instancia;
    }
}
