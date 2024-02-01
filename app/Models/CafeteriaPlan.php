<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CafeteriaPlan
 *
 * @property integer $id
 * @property json $pockets_budget_annual
 * @property json $pockets_budget_monthly
 */

class CafeteriaPlan extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'cafeteria_plans';

    protected $fillable = [
        'pockets_budget_annual',
        'pockets_budget_monthly',
    ];

    const CAFETERIA_BUDGET = 400000;
    const POCKET_BUDGET_LIMIT = 200000;

    const A_POCKET = 'A';
    const B_POCKET = 'B';
    const C_POCKET = 'C';

    const POCKETS = [
        self::A_POCKET,
        self::B_POCKET,
        self::C_POCKET
    ];

    const CURRENCY = 'HUF';

    const MONTHS = [
        'January',
        'February',
        'March',
        'April',
        'May',
        'June',
        'July',
        'August',
        'September',
        'October',
        'November',
        'December'
    ];
    

}
