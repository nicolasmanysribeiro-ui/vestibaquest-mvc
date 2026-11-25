<?php $c = $_GET['c'] ?? 'painel'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($titulo ?? 'VestibaQuest') ?> | VestibaQuest</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<aside class="menu">
    <a href="index.php" class="marca">Vestiba<span>Quest</span></a>
    <p class="sub">Gestão de simulados</p>
    <nav>
        <a href="index.php?c=painel" class="<?= $c === 'painel' ? 'ativo' : '' ?>">Painel</a>
        <a href="index.php?c=universidade" class="<?= $c === 'universidade' ? 'ativo' : '' ?>">Universidades</a>
        <a href="index.php?c=simulado" class="<?= $c === 'simulado' ? 'ativo' : '' ?>">Simulados</a>
    </nav>
    <p class="rodape">PHP · MVC · DAO · MySQL</p>
</aside>
<main class="conteudo">
    <?php if (!empty($flash)): ?>
        <div class="aviso <?= e($flash['tipo']) ?>"><?= e($flash['mensagem']) ?></div>
    <?php endif; ?>
    <?php require $arquivoView; ?>
</main>
</body>
</html>
