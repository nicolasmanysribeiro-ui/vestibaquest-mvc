<?php
namespace App\Controller;

use App\Model\Dao\SimuladoDao;
use App\Model\Dao\UniversidadeDao;

class PainelController extends Controller
{
    public function index(): void
    {
        $uDao = new UniversidadeDao();
        $sDao = new SimuladoDao();

        $this->render('painel', [
            'titulo' => 'Painel',
            'totalUniversidades' => $uDao->contar(),
            'totalSimulados' => $sDao->contar(),
            'totalQuestoes' => $sDao->totalQuestoes(),
            'universidades' => $uDao->listarTodos(),
        ]);
    }
}
