<header class="topo">
    <div>
        <h1>Simulados</h1>
        <p class="legenda">Provas antigas ligadas à universidade de origem.</p>
    </div>
    <a class="botao" href="index.php?c=simulado&a=novo<?= $filtro ? '&universidade=' . $filtro : '' ?>">+ Novo simulado</a>
</header>

<form class="filtro" method="get">
    <input type="hidden" name="c" value="simulado">
    <label>Filtrar por universidade
        <select name="universidade" onchange="this.form.submit()">
            <option value="0">Todas</option>
            <?php foreach ($universidades as $u): ?>
                <option value="<?= $u->getId() ?>" <?= $filtro === $u->getId() ? 'selected' : '' ?>><?= e($u->getSigla()) ?> · <?= e($u->getNome()) ?></option>
            <?php endforeach; ?>
        </select>
    </label>
</form>

<?php require __DIR__ . '/_tabela.php'; ?>
