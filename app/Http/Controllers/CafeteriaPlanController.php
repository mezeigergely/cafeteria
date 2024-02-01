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
        list($pocketsBudgetAnnual, $pocketsBudgetMonthly) = $this->getPocketsBudgetFromRequest($request);

        if($this->cafeteriaPlanService->savePlan($pocketsBudgetAnnual, $pocketsBudgetMonthly)){
            return response()->json(['message' => CafeteriaPlan::SAVE_SUCCESS], 200);
        }

        return response()->json(['message' => CafeteriaPlan::ERROR]);
        
    }

    public function getPlanData()
    {
        if($responseData = [
            'budget' => CafeteriaPlan::CAFETERIA_BUDGET,
            'currency' => CafeteriaPlan::CURRENCY,
            'pockets' => CafeteriaPlan::POCKETS,
            'pocketBudgetLimit' => CafeteriaPlan::POCKET_BUDGET_LIMIT,
            'months' => CafeteriaPlan::MONTHS,
        ]){
            return response()->json($responseData, 200);
        }

        return response()->json(['message' => CafeteriaPlan::ERROR]);
    }

    public function generateXml(CafeteriaPlanRequest $request)
    {
        list($pocketsBudgetAnnual, $pocketsBudgetMonthly) = $this->getPocketsBudgetFromRequest($request);

        $data = $this->cafeteriaPlanService->transformPlanDataForXml($pocketsBudgetAnnual, $pocketsBudgetMonthly);
        $xmlContent = $this->cafeteriaPlanService->generateXmlFromData($data);

        $filename = $this->cafeteriaPlanService->generateXmlFilename();

        $filePath = $this->cafeteriaPlanService->getXmlFilePath($filename);

        if($this->cafeteriaPlanService->saveXml($filename, $xmlContent)){
            return response()->json(['filePath' => $filePath, 'filename' => $filename, 'message' => CafeteriaPlan::XML_SUCCESS],200);
        }

        return response()->json(['message' => CafeteriaPlan::ERROR]);
    }

    protected function getPocketsBudgetFromRequest(CafeteriaPlanRequest $request)
    {
        $pocketsBudgetAnnual = $request->input('pockets_budget_annual');
        $pocketsBudgetMonthly = $request->input('pockets_budget_monthly');

        return [$pocketsBudgetAnnual, $pocketsBudgetMonthly];
    }
}
