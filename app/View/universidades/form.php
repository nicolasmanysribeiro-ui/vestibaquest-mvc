<header class="topo">
    <h1><?= e($titulo) ?></h1>
</header>

<?php if ($erros): ?>
    <div class="aviso erro"><?php foreach ($erros as $erro): ?><div><?= e($erro) ?></div><?php endforeach; ?></div>
<?php endif; ?>

<form class="formulario" method="post" action="index.php?c=universidade&a=salvar">
    <input type="hidden" name="id" value="<?= e($universidade->getId()) ?>">

    <label>Nome
        <input name="nome" value="<?= e($universidade->getNome()) ?>" placeholder="Universidade Estadual de Ponta Grossa" required>
    </label>
    <div class="linha">
        <label>Sigla
            <input name="sigla" value="<?= e($universidade->getSigla()) ?>" placeholder="UEPG" maxlength="15" required>
        </label>
        <label>Cidade
            <input name="cidade" value="<?= e($universidade->getCidade()) ?>" placeholder="Ponta Grossa" required>
        </label>
        <label>Tipo
            <select name="tipo">
                <?php foreach ($tipos as $tipo): ?>
                    <option <?= $tipo === $universidade->getTipo() ? 'selected' : '' ?>><?= e($tipo) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
    </div>

    <div class="botoes">
        <button class="botao">Salvar</button>
        <a href="index.php?c=universidade" class="botao fantasma">Cancelar</a>
    </div>
</form>
