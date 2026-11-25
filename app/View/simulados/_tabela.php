<table class="tabela">
    <thead>
    <tr><th>Universidade</th><th>Título</th><th>Ano</th><th>Área</th><th>Questões</th><th>Dificuldade</th><th></th></tr>
    </thead>
    <tbody>
    <?php foreach ($simulados as $s): ?>
        <tr>
            <td><strong><?= e($s->getUniversidade()->getSigla()) ?></strong></td>
            <td><?= e($s->getTitulo()) ?></td>
            <td><?= $s->getAno() ?></td>
            <td><?= e($s->getArea()) ?></td>
            <td><?= $s->getQtdQuestoes() ?></td>
            <td><span class="etiqueta nivel-<?= e($s->getDificuldade()) ?>"><?= e($s->getDificuldade()) ?></span></td>
            <td><div class="acoes">
                <a href="index.php?c=simulado&a=editar&id=<?= $s->getId() ?>">Editar</a>
                <form method="post" action="index.php?c=simulado&a=excluir" onsubmit="return confirm('Excluir este simulado?')">
                    <input type="hidden" name="id" value="<?= $s->getId() ?>">
                    <button class="link-perigo">Excluir</button>
                </form>
            </div></td>
        </tr>
    <?php endforeach; ?>
    <?php if (!$simulados): ?>
        <tr><td colspan="7" class="vazio">Nenhum simulado por aqui ainda.</td></tr>
    <?php endif; ?>
    </tbody>
</table>
