<header class="topo">
    <div>
        <h1>Painel de simulados</h1>
        <p class="legenda">Provas antigas das universidades do Paraná organizadas para o seu estudo.</p>
    </div>
</header>

<section class="numeros">
    <div class="cartao-num"><strong><?= $totalUniversidades ?></strong><span>universidades</span></div>
    <div class="cartao-num"><strong><?= $totalSimulados ?></strong><span>simulados</span></div>
    <div class="cartao-num"><strong><?= $totalQuestoes ?></strong><span>questões no total</span></div>
</section>

<h2 class="secao">Simulados por universidade</h2>
<div class="grade">
    <?php foreach ($universidades as $u): ?>
        <a class="cartao-uni" href="index.php?c=universidade&a=ver&id=<?= $u->getId() ?>">
            <span class="sigla"><?= e($u->getSigla()) ?></span>
            <span class="nome"><?= e($u->getNome()) ?></span>
            <span class="qtd"><?= $u->getTotalSimulados() ?> simulado(s)</span>
        </a>
    <?php endforeach; ?>
</div>
