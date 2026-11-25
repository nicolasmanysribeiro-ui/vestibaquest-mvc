<header class="topo">
    <h1><?= e($titulo) ?></h1>
</header>

<?php if ($erros): ?>
    <div class="aviso erro"><?php foreach ($erros as $erro): ?><div><?= e($erro) ?></div><?php endforeach; ?></div>
<?php endif; ?>

<?php if (!$universidades): ?>
    <div class="aviso erro">Cadastre uma universidade antes de criar simulados.</div>
<?php endif; ?>

<form class="formulario" method="post" action="index.php?c=simulado&a=salvar">
    <input type="hidden" name="id" value="<?= e($simulado->getId()) ?>">

    <label>Universidade
        <select name="universidade_id" required>
            <option value="">Escolha...</option>
            <?php foreach ($universidades as $u): ?>
                <option value="<?= $u->getId() ?>" <?= $u->getId() === $simulado->getUniversidadeId() ? 'selected' : '' ?>>
                    <?= e($u->getSigla()) ?> · <?= e($u->getNome()) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label>

    <label>Título
        <input name="titulo" value="<?= e($simulado->getTitulo()) ?>" placeholder="Vestibular de Verão - 1ª fase" required>
    </label>

    <div class="linha">
        <label>Ano
            <input type="number" name="ano" value="<?= e($simulado->getAno() ?: '') ?>" min="1990" max="<?= date('Y') ?>" required>
        </label>
        <label>Questões
            <input type="number" name="qtd_questoes" value="<?= e($simulado->getQtdQuestoes() ?: '') ?>" min="1" max="200" required>
        </label>
        <label>Área
            <select name="area">
                <?php foreach ($areas as $area): ?>
                    <option <?= $area === $simulado->getArea() ? 'selected' : '' ?>><?= e($area) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label>Dificuldade
            <select name="dificuldade">
                <?php foreach ($dificuldades as $d): ?>
                    <option <?= $d === $simulado->getDificuldade() ? 'selected' : '' ?>><?= e($d) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
    </div>

    <div class="botoes">
        <button class="botao">Salvar</button>
        <a href="javascript:history.back()" class="botao fantasma">Cancelar</a>
    </div>
</form>
