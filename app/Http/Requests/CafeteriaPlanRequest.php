<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CafeteriaPlanRequest extends FormRequest
{
    public function rules()
    {
        return [
            'pockets_budget_annual' => 'required|string',
            'pockets_budget_monthly' => 'required|string',
        ];
    }
}
