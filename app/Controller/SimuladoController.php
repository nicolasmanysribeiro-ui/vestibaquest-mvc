<?php
namespace App\Controller;

use App\Exception\RegraNegocioException;
use App\Exception\ValidacaoException;
use App\Model\Dao\SimuladoDao;
use App\Model\Dao\UniversidadeDao;
use App\Model\Entity\Simulado;

class SimuladoController extends Controller
{
    private SimuladoDao $dao;
    private UniversidadeDao $universidadeDao;

    public function __construct()
    {
        $this->dao = new SimuladoDao();
        $this->universidadeDao = new UniversidadeDao();
    }

    // READ: lista todos ou filtra por universidade
    public function index(): void
    {
        $filtro = (int) ($_GET['universidade'] ?? 0);
        $this->render('simulados/lista', [
            'titulo' => 'Simulados',
            'simulados' => $filtro ? $this->dao->listarPorUniversidade($filtro) : $this->dao->listarTodos(),
            'universidades' => $this->universidadeDao->listarTodos(),
            'filtro' => $filtro,
        ]);
    }

    public function novo(): void
    {
        $s = new Simulado();
        $s->setUniversidadeId((int) ($_GET['universidade'] ?? 0));
        $s->setAno((int) date('Y'));
        $this->formulario($s);
    }

    public function editar(): void
    {
        $s = $this->dao->buscarPorId($this->idDaUrl());
        if (!$s) {
            $this->redirecionar('c=simulado', 'Simulado não encontrado.', 'erro');
        }
        $this->formulario($s);
    }

    // CREATE e UPDATE
    public function salvar(): void
    {
        $this->exigirPost();
        $id = $this->idDaUrl();

        $s = new Simulado();
        $s->setId($id ?: null);
        $s->setUniversidadeId((int) ($_POST['universidade_id'] ?? 0));
        $s->setTitulo($_POST['titulo'] ?? '');
        $s->setAno((int) ($_POST['ano'] ?? 0));
        $s->setArea($_POST['area'] ?? '');
        $s->setQtdQuestoes((int) ($_POST['qtd_questoes'] ?? 0));
        $s->setDificuldade($_POST['dificuldade'] ?? '');

        try {
            $s->validar();
            if (!$this->universidadeDao->buscarPorId($s->getUniversidadeId())) {
                throw new RegraNegocioException('A universidade escolhida não existe.');
            }
            $novo = $s->isNova();
            $novo ? $this->dao->inserir($s) : $this->dao->atualizar($s);
            $this->redirecionar(
                'c=universidade&a=ver&id=' . $s->getUniversidadeId(),
                $novo ? "Simulado \"{$s->getTitulo()}\" cadastrado!" : "Simulado \"{$s->getTitulo()}\" atualizado!"
            );
        } catch (ValidacaoException $e) {
            $this->formulario($s, $e->getErros());
        } catch (RegraNegocioException $e) {
            $this->formulario($s, [$e->getMessage()]);
        }
    }

    // DELETE
    public function excluir(): void
    {
        $this->exigirPost();
        $s = $this->dao->buscarPorId($this->idDaUrl());
        if (!$s) {
            $this->redirecionar('c=simulado', 'Simulado não encontrado.', 'erro');
        }
        $this->dao->excluir($s->getId());
        $this->redirecionar('c=universidade&a=ver&id=' . $s->getUniversidadeId(), "Simulado \"{$s->getTitulo()}\" excluído.");
    }

    private function formulario(Simulado $s, array $erros = []): void
    {
        $this->render('simulados/form', [
            'titulo' => $s->isNova() ? 'Novo simulado' : 'Editar simulado',
            'simulado' => $s,
            'universidades' => $this->universidadeDao->listarTodos(),
            'areas' => Simulado::AREAS,
            'dificuldades' => Simulado::DIFICULDADES,
            'erros' => $erros,
        ]);
    }
}
