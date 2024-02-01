<?php

namespace App\Http\Controllers;

use App\Models\CafeteriaPlan;
use App\Http\Requests\CafeteriaPlanRequest;
use App\Http\Services\CafeteriaPlanService;

class CafeteriaPlanController extends Controller
{
    protected $cafeteriaPlanService;

    public function __construct(CafeteriaPlanService $cafeteriaPlanService)
    {
        $this->cafeteriaPlanService = $cafeteriaPlanService;
    }

    public function index()
    {
        return view('welcome');
    }

    public function save(CafeteriaPlanRequest $request)
    {
        $pocketsBudgetAnnual = $request->input('pockets_budget_annual');
        $pocketsBudgetMonthly = $request->input('pockets_budget_monthly');

        $this->cafeteriaPlanService->savePlan($pocketsBudgetAnnual, $pocketsBudgetMonthly);
    }

    public function getPlanData()
    {
        $responseData = [
            'budget' => CafeteriaPlan::CAFETERIA_BUDGET,
            'currency' => CafeteriaPlan::CURRENCY,
            'pockets' => CafeteriaPlan::POCKETS,
            'pocketBudgetLimit' => CafeteriaPlan::POCKET_BUDGET_LIMIT,
            'months' => CafeteriaPlan::MONTHS,
        ];

        return response()->json($responseData, 200);
    }
}
