<?php

namespace App\Http\Services;

use App\Models\CafeteriaPlan;

class CafeteriaPlanService
{
    public function savePlan($pocketsBudgetAnnual, $pocketsBudgetMonthly)
    {
        $resultArray = array_map('intval', explode(',', $pocketsBudgetAnnual));
        $resultArray2 = array_map('floatval', explode(',', $pocketsBudgetMonthly));

        CafeteriaPlan::create([
            'pockets_budget_annual' => json_encode($resultArray),
            'pockets_budget_monthly' => json_encode($resultArray2),
        ]);
        
    }
}
