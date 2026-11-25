<header class="topo">
    <div>
        <h1>Universidades</h1>
        <p class="legenda">Cada universidade guarda seus próprios simulados.</p>
    </div>
    <a class="botao" href="index.php?c=universidade&a=novo">+ Nova universidade</a>
</header>

<table class="tabela">
    <thead>
    <tr><th>Sigla</th><th>Nome</th><th>Cidade</th><th>Tipo</th><th>Simulados</th><th></th></tr>
    </thead>
    <tbody>
    <?php foreach ($universidades as $u): ?>
        <tr>
            <td><strong><?= e($u->getSigla()) ?></strong></td>
            <td><?= e($u->getNome()) ?></td>
            <td><?= e($u->getCidade()) ?></td>
            <td><span class="etiqueta"><?= e($u->getTipo()) ?></span></td>
            <td><?= $u->getTotalSimulados() ?></td>
            <td><div class="acoes">
                <a href="index.php?c=universidade&a=ver&id=<?= $u->getId() ?>">Ver</a>
                <a href="index.php?c=universidade&a=editar&id=<?= $u->getId() ?>">Editar</a>
                <form method="post" action="index.php?c=universidade&a=excluir" onsubmit="return confirm('Excluir <?= e($u->getSigla()) ?>?')">
                    <input type="hidden" name="id" value="<?= $u->getId() ?>">
                    <button class="link-perigo">Excluir</button>
                </form>
            </div></td>
        </tr>
    <?php endforeach; ?>
    <?php if (!$universidades): ?>
        <tr><td colspan="6" class="vazio">Nenhuma universidade cadastrada ainda.</td></tr>
    <?php endif; ?>
    </tbody>
</table>
