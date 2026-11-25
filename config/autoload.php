<?php
// Carrega as classes automaticamente: App\Model\Dao\UniversidadeDao -> app/Model/Dao/UniversidadeDao.php
spl_autoload_register(function (string $classe): void {
    $prefixo = 'App\\';
    if (strncmp($classe, $prefixo, strlen($prefixo)) !== 0) {
        return;
    }
    $relativo = str_replace('\\', '/', substr($classe, strlen($prefixo)));
    $arquivo = __DIR__ . '/../app/' . $relativo . '.php';
    if (is_file($arquivo)) {
        require $arquivo;
    }
});
