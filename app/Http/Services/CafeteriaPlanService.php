<?php

namespace App\Http\Services;

use App\Models\CafeteriaPlan;
use Exception;
use Illuminate\Support\Facades\Storage;

class CafeteriaPlanService
{
    
    public function transformPlanData($planData, $type)
    {
        $resultArray = array_map($type, explode(',', $planData));
        
        return $resultArray;
    }
    
    public function transformPlanDataForXmlOrCsv($pocketsBudgetAnnual, $pocketsBudgetMonthly)
    {
        $data = [
            'pocketsBudgetAnnual' => explode(',', $pocketsBudgetAnnual),
            'pocketsBudgetMonthly' => explode(',', $pocketsBudgetMonthly),
        ];

        return $data;
    }

    public function savePlan($pocketsBudgetAnnual, $pocketsBudgetMonthly)
    {
        $resultPba = $this->transformPlanData($pocketsBudgetAnnual, 'intval');
        $resultPbm = $this->transformPlanData($pocketsBudgetMonthly, 'floatval');

        
        if(CafeteriaPlan::create([
            'pockets_budget_annual' => json_encode($resultPba),
            'pockets_budget_monthly' => json_encode($resultPbm),
        ])){
            return true;
        }

        return false;
        
    }

    public function generateXmlFromData(array $data)
    {
        $xml = new \SimpleXMLElement('<root/>');
        
        foreach ($data as $key => $values) {
            $element = $xml->addChild($key);

            foreach ($values as $index => $value) {
                $element->addChild('value-pocket-' . ($index + 1), $value);
            }
        }

        return $xml->asXML();
    }

    public function generateCsv($filename, $data)
    {
        try {
            $handle = fopen(storage_path($filename), 'w');
            fputcsv($handle, ['Pocket', 'YearlyAmount', 'MonthlyAmount']);

            foreach ($data['pocketsBudgetAnnual'] as $index => $yearly) {
                $monthly = $data['pocketsBudgetMonthly'][$index];
                $pocket = 'Pocket' . ($index + 1);

                fputcsv($handle, [$pocket, $yearly, $monthly]);
            }

            fclose($handle);

            return true;
        } catch (Exception) {

            return false;
        }
    }

    public function generateFilename($type)
    {
        return 'generated_'.$type.'_' . now()->format('YmdHis') . '.'.$type;
    }

    public function saveXml($filename, $xmlContent)
    {
        if(Storage::put($filename, $xmlContent)){
            return true;
        }
        return false;
    }

    public function getXmlFilePath($filename)
    {
        return Storage::path($filename);
    }
}
