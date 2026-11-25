<header class="topo">
    <div>
        <p class="voltar"><a href="index.php?c=universidade">Universidades</a> / <?= e($universidade->getSigla()) ?></p>
        <h1><?= e($universidade->getNome()) ?></h1>
        <p class="legenda"><?= e($universidade->getCidade()) ?> · <?= e($universidade->getTipo()) ?></p>
    </div>
    <div class="botoes">
        <a class="botao fantasma" href="index.php?c=universidade&a=editar&id=<?= $universidade->getId() ?>">Editar</a>
        <a class="botao" href="index.php?c=simulado&a=novo&universidade=<?= $universidade->getId() ?>">+ Novo simulado</a>
    </div>
</header>

<h2 class="secao"><?= count($simulados) ?> simulado(s) desta universidade</h2>
<?php require __DIR__ . '/../simulados/_tabela.php'; ?>
