<?php
namespace App\Controller;

use App\Exception\RegraNegocioException;
use App\Exception\ValidacaoException;
use App\Model\Dao\SimuladoDao;
use App\Model\Dao\UniversidadeDao;
use App\Model\Entity\Universidade;

class UniversidadeController extends Controller
{
    private UniversidadeDao $dao;
    private SimuladoDao $simuladoDao;

    public function __construct()
    {
        $this->dao = new UniversidadeDao();
        $this->simuladoDao = new SimuladoDao();
    }

    // READ: lista todas
    public function index(): void
    {
        $this->render('universidades/lista', [
            'titulo' => 'Universidades',
            'universidades' => $this->dao->listarTodos(),
        ]);
    }

    // READ: detalhe com os simulados filhos
    public function ver(): void
    {
        $universidade = $this->dao->buscarPorId($this->idDaUrl());
        if (!$universidade) {
            $this->redirecionar('c=universidade', 'Universidade não encontrada.', 'erro');
        }
        $this->render('universidades/ver', [
            'titulo' => $universidade->getSigla(),
            'universidade' => $universidade,
            'simulados' => $this->simuladoDao->listarPorUniversidade($universidade->getId()),
        ]);
    }

    public function novo(): void
    {
        $this->formulario(new Universidade());
    }

    public function editar(): void
    {
        $universidade = $this->dao->buscarPorId($this->idDaUrl());
        if (!$universidade) {
            $this->redirecionar('c=universidade', 'Universidade não encontrada.', 'erro');
        }
        $this->formulario($universidade);
    }

    // CREATE e UPDATE: se tem id atualiza, se não tem cria
    public function salvar(): void
    {
        $this->exigirPost();
        $id = $this->idDaUrl();

        $u = new Universidade($_POST['nome'] ?? '', $_POST['sigla'] ?? '', $_POST['cidade'] ?? '', $_POST['tipo'] ?? '');
        $u->setId($id ?: null);

        try {
            $u->validar();
            if ($this->dao->siglaEmUso($u->getSigla(), $u->getId())) {
                throw new RegraNegocioException("A sigla {$u->getSigla()} já está cadastrada.");
            }
            if ($u->isNova()) {
                $this->dao->inserir($u);
                $this->redirecionar('c=universidade', "Universidade {$u->getSigla()} cadastrada!");
            }
            $this->dao->atualizar($u);
            $this->redirecionar('c=universidade', "Universidade {$u->getSigla()} atualizada!");
        } catch (ValidacaoException $e) {
            $this->formulario($u, $e->getErros());
        } catch (RegraNegocioException $e) {
            $this->formulario($u, [$e->getMessage()]);
        }
    }

    // DELETE: só deixa apagar se não tiver simulados ligados
    public function excluir(): void
    {
        $this->exigirPost();
        $id = $this->idDaUrl();
        $universidade = $this->dao->buscarPorId($id);
        if (!$universidade) {
            $this->redirecionar('c=universidade', 'Universidade não encontrada.', 'erro');
        }

        $qtd = $this->simuladoDao->contarPorUniversidade($id);
        if ($qtd > 0) {
            $this->redirecionar(
                'c=universidade',
                "Não dá para excluir a {$universidade->getSigla()}: ela ainda tem {$qtd} simulado(s). Exclua ou mova os simulados primeiro.",
                'erro'
            );
        }

        $this->dao->excluir($id);
        $this->redirecionar('c=universidade', "Universidade {$universidade->getSigla()} excluída.");
    }

    private function formulario(Universidade $u, array $erros = []): void
    {
        $this->render('universidades/form', [
            'titulo' => $u->isNova() ? 'Nova universidade' : 'Editar universidade',
            'universidade' => $u,
            'tipos' => Universidade::TIPOS,
            'erros' => $erros,
        ]);
    }
}
